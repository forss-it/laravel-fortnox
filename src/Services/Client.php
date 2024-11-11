<?php

namespace KFoobar\Fortnox\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use KFoobar\Fortnox\Exceptions\FortnoxException;
use KFoobar\Fortnox\Interfaces\ClientInterface;
use KFoobar\Fortnox\Services\Token;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Middleware;

class Client implements ClientInterface
{
    /**
     * Constructs a new instance.
     */
    protected $client;

    public function __construct()
    {
        $this->client = Http::baseUrl($this->getHost())
            ->timeout($this->getTimeout())
            ->withToken($this->getAccessToken())
            ->asJson()
            ->acceptJson();
    }

    /**
     * Sends GET request.
     *
     * @param string $endpoint
     * @param array  $data
     * @param array  $filter
     *
     * @return mixed
     */
    public function get(string $endpoint, array $data = [], array $filter = []): mixed
    {
        $response = $this->client->get($endpoint, $data);

        if ($response->failed()) {
            $this->catchError($response);
        }

        return $response;
    }

    /**
     * Sends PUT request.
     *
     * @param string $endpoint
     * @param array  $data
     *
     * @return mixed
     */
    public function put(string $endpoint, array $data = []): mixed
    {
        $response = $this->client->put($endpoint, $data);

        if ($response->failed()) {
            $this->catchError($response);
        }

        return $response;
    }

    /**
     * Sends POST request.
     *
     * @param string $endpoint
     * @param array  $data
     * @param array  $filter
     *
     * @return mixed
     */
    public function post(string $endpoint, array $data = [], array $filter = []): mixed
    {
        $response = $this->client->post($endpoint, $data);

        if ($response->failed()) {
            $this->catchError($response);
        }

        return $response;
    }

    /**
     * Send DELETE requests.
     *
     * @param string $endpoint
     * @param array  $data
     *
     * @return mixed
     */
    public function delete(string $endpoint, array $data = []): mixed
    {
        $response = $this->client->delete($endpoint, $data);

        if ($response->failed()) {
            $this->catchError($response);
        }

        return $response;
    }

    /**
     * Uploads a file.
     *
     * @param string $endpoint
     * @param string $fileName
     * @param string $fileContents
     *
     * @return mixed
     */
    public function upload(string $endpoint, string $fileName, string $fileContents): mixed
    {

        $response = $this->client
        ->attach('file', $fileContents, $fileName)
        ->contentType('multipart/form-data')
        ->withMiddleware(
            Middleware::mapRequest(function (RequestInterface $request) {
            $request = $request->withHeader(
                'Content-type',
                'multipart/form-data; boundary=' .
                $request->getBody()->getBoundary()
            );
                return $request;
            })
        )
        ->post($endpoint);

        if ($response->failed()) {
            $this->catchError($response);
        }

        return $response->json();
    }

    /**
     * Refresh the access token.
     *
     * @return mixed
     */
    public function refresh(): mixed
    {
        return $this->refreshAccessToken();
    }

    /**
     * Catch given error message from Fortnox.
     *
     * @param  \Illuminate\Http\Client\Response             $response
     *
     * @throws \KFoobar\Fortnox\Exceptions\FortnoxException (description)
     *
     * @return void
     */
    protected function catchError(Response $response): void
    {
        if ($response->json('ErrorInformation')) {
            $message = !empty($response->json('ErrorInformation.message'))
                ? $response->json('ErrorInformation.message')
                : $response->json('ErrorInformation.Message');

            $code = !empty($response->json('ErrorInformation.code'))
                ? $response->json('ErrorInformation.code')
                : $response->json('ErrorInformation.Code');

            throw new FortnoxException(sprintf('%s (%s)', $message, $code), $response->status());
        }
    }

    /**
     * Gets the host.
     *
     * @return null|string
     */
    protected function getHost(): ?string
    {
        return config('fortnox.host');
    }

    /**
     * Gets the client id.
     *
     * @return null|string
     */
    protected function getClientId(): ?string
    {
        return config('fortnox.client_id');
    }

    /**
     * Gets the client secret.
     *
     * @return null|string
     */
    protected function getClientSecret(): ?string
    {
        return config('fortnox.client_secret');
    }

    /**
     * Gets the access token.
     * Cache is set to 55 minutes (3300).
     *
     * @return null|string
     */
    protected function getAccessToken(): ?string
    {
        return Token::put('fortnox-access-token', $this->refreshAccessToken(), 3300);
    }

    /**
     * Gets the refresh token.
     *
     * @throws \KFoobar\Fortnox\Exceptions\FortnoxException
     *
     * @return string
     */
    protected function getRefreshToken(): string
    {
        $token = Token::get('fortnox-refresh-token');
        if ($token) {
            return $token;
        }

        if (!empty(config('fortnox.refresh_token'))) {
            return config('fortnox.refresh_token');
        }

        throw new FortnoxException('Refresh token not found or not valid');
    }

    /**
     * Gets the timeout.
     *
     * @return null|string
     */
    protected function getTimeout(): ?string
    {
        return config('fortnox.timeout');
    }

    /**
     * Refreshes the access and refresh token.
     * Cache is set to 25 day (2160000).
     *
     * @throws \KFoobar\Fortnox\Exceptions\FortnoxException
     *
     * @return string
     */
    protected function refreshAccessToken(): string
    {
        $response = Http::withBasicAuth($this->getClientId(), $this->getClientSecret())
            ->timeout($this->getTimeout())
            ->asForm()
            ->post('https://apps.fortnox.se/oauth-v1/token', [
                'grant_type'    => 'refresh_token',
                'refresh_token' => $this->getRefreshToken(),
            ]);

        if ($response->failed()) {
            throw new FortnoxException('Failed to refresh token.');
        }

        if (empty($response->json('access_token'))) {
            throw new FortnoxException('Failed to retrieve access token from response.');
        }

        if (empty($response->json('refresh_token'))) {
            throw new FortnoxException('Failed to retrieve refresh token from response.');
        }

        Token::put('fortnox-refresh-token', $response->json('refresh_token'), 2160000);

        return $response->json('access_token');
    }
}

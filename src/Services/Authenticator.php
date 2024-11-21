<?php
namespace Warbio\Fortnox\Services;
use Warbio\Fortnox\Controllers\FortnoxOauthController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Warbio\Fortnox\Exceptions\FortnoxException;
use Warbio\Fortnox\Services\Token;
class Authenticator {


    /**
     * Returns the authorization URL.
     * @param array $scope
     * @param string $state
     * @return string
     */
    public function authUrl(array $scope = [], string $state = null): string
    {
        if(is_null($state)) {
            $state = bin2hex(random_bytes(16));
        }
        
        $query = http_build_query([
            'client_id'     => config('fortnox.client_id'),
            'redirect_uri'  => route('fortnox.oauth.callback'),
            'response_type' => 'code',
            'scope'         => implode(' ', $scope),
            'state'         => $state,
            'access_type'   => 'offline',
            'account_type'  => 'service',
        ]);

        return sprintf('https://apps.fortnox.se/oauth-v1/auth?%s', $query);
    }


    /**
     * Authorize the integration using provided authorization code.
     * @param string $code
     * @return void
     */
    public function authorize(string $code) : void 
    {
        $response = Http::withBasicAuth(config('fortnox.client_id'), config('fortnox.client_secret'))
            ->asForm()
            ->post('https://apps.fortnox.se/oauth-v1/token', [
                'grant_type'    => 'authorization_code',
                'code'          => $code,
                'redirect_uri'  => route('fortnox.oauth.callback'),
            ]);
        
        if ($response->failed()) {
            throw new FortnoxException('Failed to authorize.');
        }

        if (empty($response->json('access_token'))) {
            throw new FortnoxException('Failed to retrieve access token from response.');
        }

        Token::put('fortnox-access-token', $response->json('access_token'), $response->json('expires_in'));
        Token::put('fortnox-refresh-token', $response->json('refresh_token'), 2160000);
    }

    /**
     * Register laravel routes.
     * @return void
     */
    public function routes() 
    {
        Route::get('fortnox/oauth/authorize', [FortnoxOauthController::class, 'authorize'])->name('fortnox.oauth.authorize');
        Route::get('fortnox/oauth/callback', [FortnoxOauthController::class, 'callback'])->name('fortnox.oauth.callback');
    }


    /**
     * Return true if the user is authenticated.
     * @return bool
     */
    public function isAuthenticated() : bool
    {
        return !empty(Token::get('fortnox-access-token')) || !empty(Token::get('fortnox-refresh-token'));
    }


    /**
     * Revoke the access token.
     * @return void
     */
    public function revoke() : void
    {
        Token::forget('fortnox-access-token');
        Token::forget('fortnox-refresh-token');
    }



}
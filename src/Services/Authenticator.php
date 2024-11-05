<?php
namespace KFoobar\Fortnox\Services;
use KFoobar\Fortnox\Controllers\FortnoxOauthController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use KFoobar\Fortnox\Exceptions\FortnoxException;
class Authenticator {

    public function authUrl($scope = [], $state = null): string
    {
        if(is_null($state)) {
            $state = bin2hex(random_bytes(16));
        }
        
        $query = http_build_query([
            'client_id'     => config('fortnox.client_id'),
            'redirect_uri'  => route('fortnox.oauth.callback'),
            'response_type' => 'code',
            'scope'         => implode(',', $scope),
            'state'         => $state,
            'access_type'   => 'offline',
            'account_type'  => 'service',
        ]);

        return sprintf('https://apps.fortnox.se/oauth-v1/auth?%s', $query);
    }

    public function authorize($code) {
        $response = Http::withBasicAuth(config('fortnox.client_id'), config('fortnox.client_secret'))
            ->asForm()
            ->post('https://apps.fortnox.se/oauth-v1/token', [
                'grant_type'    => 'authorization_code',
                'code'          => $code,
            ]);
        
        dd($response, $response->json());
        if ($response->failed()) {
            throw new FortnoxException('Failed to authorize.');
        }

        if (empty($response->json('access_token'))) {
            throw new FortnoxException('Failed to retrieve access token from response.');
        }

      

        Cache::put('fortnox-access-token', $response->json('access_token'), $response->json('expires_in'));
        Cache::put('fortnox-refresh-token', $response->json('refresh_token'), 2160000);
    }

    public function routes() {
        Route::get('fortnox/oauth/authorize', [FortnoxOauthController::class, 'authorize'])->name('fortnox.oauth.authorize');
        Route::get('fortnox/oauth/callback', [FortnoxOauthController::class, 'callback'])->name('fortnox.oauth.callback');
    }



}
<?php
namespace KFoobar\Fortnox\Services;
use KFoobar\Fortnox\Controllers\FortnoxOauthController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
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
        ]);

        return sprintf('https://apps.fortnox.se/oauth-v1/auth?%s', $query);
    }

    public function routes() {
        Route::get('fortnox/oauth/authorize', [FortnoxOauthController::class, 'authorize'])->name('fortnox.oauth.authorize');
        Route::get('fortnox/oauth/callback', [FortnoxOauthController::class, 'callback'])->name('fortnox.oauth.callback');
    }



}
<?php
namespace KFoobar\Fortnox\Services;
use KFoobar\Fortnox\Controllers\FortnoxOauthController;
use Illuminate\Support\Facades\Cache;
class Authenticator {

    public function authUrl($scope = []): string
    {
        $state = uuid();
        Cache::put('fortnox-oauth-state', $state, 300);

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
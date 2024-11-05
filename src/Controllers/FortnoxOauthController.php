<?php
namespace KFoobar\Fortnox\Controllers;
use KFoobar\Fortnox\Facades\FortnoxAuthenticator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
class FortnoxOauthController extends Controller {

    public function authorize() {

        $scope = explode(',', config('fortnox.scope'));
        $state = bin2hex(random_bytes(16));
        Cache::put('fortnox-oauth-state', $state, 300);
        return redirect()->away(FortnoxAuthenticator::AuthUrl($scope, $state));
    }

    public function callback() {
        $code = request()->get('code');
        $state = request()->get('state');
        
        //Validate state
        if ($state !== Cache::get('fortnox-oauth-state')) {
            return response()->json(['error' => 'Invalid state'], 400);
        }

        dd($code);
    }

}
<?php

return [

    'host'  => env('FORTNOX_HOST', 'https://api.fortnox.se/3/'),
    'client_id' => env('FORTNOX_CLIENT_ID', ''),
    'client_secret' => env('FORTNOX_CLIENT_SECRET', ''),
    'refresh_token' => env('FORTNOX_REFRESH_TOKEN', ''),
    'timeout' => env('FORTNOX_TIMEOUT', 5),
    'token_store' => env('FORTNOX_TOKEN_STORE', 'cache'), #cache or file
    'oauth_scope' => env('FORTNOX_OAUTH_SCOPE', ''), #Comma separated list of scopes
    'oauth_redirect_url' => env('FORTNOX_REDIRECT_URL', '/'),


];

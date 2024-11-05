# Fortnox API Client for Laravel

Simplifies integration with the Fortnox API.

*Please notice! This package does not yet support all available resources in the Fortnox API*

## Requirements

- Laravel 6 or higher
- PHP 8.0 or higher
- Valid client id (from Fortnox)
- Valid client secret (from Fortnox)
- (Optional) Valid refresh token (from Fortnox)

## Installation

You can install the package via Composer:

`
composer require kfoobar/laravel-fortnox 
`

## Settings for .env
The `FORTNOX_REFRESH_TOKEN` is only required if the oauth autentication is not used.
The token driver can either be `cache`, `file` or `session` and is used for storing the access_token and refresh token.
```
FORTNOX_CLIENT_ID=
FORTNOX_CLIENT_SECRET=
FORTNOX_REFRESH_TOKEN= 
FORTNOX_TOKEN_DRIVER= 
FORTNOX_OAUTH_SCOPE=
FORTNOX_REDIRECT_URL=
```
## Authorization with Oauth2

To authenticate against to the Fortnox integration using Oauth2 you can use the
built in Oauth2 routes.

In your route file:
```php
use KFoobar\Fortnox\Facades\FortnoxAuthenticator;

FortnoxAuthenticator::routes();
```

To start the authentication you navigate to the route `fortnox.oauth.authorize`

You need to provide the scope as a comma separated list in the env variable `FORTNOX_OAUTH_SCOPE`
See valid scope at: https://www.fortnox.se/developer/guides-and-good-to-know/scopes

Once the authorization flow is completed the user will be redirected to the url in the env variable `FORTNOX_REDIRECT_URL`

The login can be verified with `FortnoxAuthenticator::isAuthenticated()`

## Authorization with provided refresh token

In order to use the Fortnox API, you need a valid refresh token. 
To get a refresh token, you need to grant access to the integration via Fortnox's OAuth2 
authorization code flow. In that process, you are assigned an *authorization code*
that you can use to exchange for a pair of token:

The **access token** - which is used to authenticate all API request - is only valid 
for 1 hour and needs to be refreshed using a refresh token. This package handles 
that process as long you have a valid refresh token.

The **refresh token** - which is used to renew the access token - is valid for 30 days. 
If it expires, you need to redo the OAuth2 authorization flow.

Every time you renew you access token, you will be assigned a new refresh token that 
is valid for another 30 days. It is therefore important that you regularly renew 
the tokens so that the refresh token does not expire.

You can renew your tokens with the following command:

```
php artisan fortnox:refresh
```

*Both the access token and the refresh token are stored in your application's cache.
Keep this in mind when you purge the cache or changes cache driver.*

## Instructions
The objects are following the naming convention of the Fortnox Developer Guide and has the same operations.

### Retrieving Objects

#### Retrieve all customers
```php
    Fortnox::customers()->all(); 
```

#### Retrieve a single customer
```php
    Fortnox::customers()->get('1234'); 
```

More instructions will come soon..



## Contributing

Contributions are welcome!

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

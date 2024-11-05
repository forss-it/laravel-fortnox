# Fortnox API Client for Laravel

A Laravel package that simplifies integration with the Fortnox API.

> **Note**: This package does not yet support all available resources in the Fortnox API.

## Requirements

- Laravel 6.x or higher
- PHP 8.0 or higher
- A valid Fortnox client ID
- A valid Fortnox client secret
- (Optional) A valid refresh token if not using OAuth2 authentication

## Installation

Install the package via Composer:

```bash
composer require kfoobar/laravel-fortnox
```

## Environment Configuration

Add the following settings to your `.env` file. The `FORTNOX_REFRESH_TOKEN` is only required if OAuth authentication is not used. The `FORTNOX_TOKEN_DRIVER` determines where the access and refresh tokens are stored, with options being `cache`, `file`, or `session`.

```env
FORTNOX_CLIENT_ID=
FORTNOX_CLIENT_SECRET=
FORTNOX_REFRESH_TOKEN= 
FORTNOX_TOKEN_DRIVER= 
FORTNOX_OAUTH_SCOPE=
FORTNOX_REDIRECT_URL=
```

## Authentication

### OAuth2 Authentication

To authenticate with Fortnox using OAuth2, use the built-in OAuth2 routes:

In your route file:

```php
use KFoobar\Fortnox\Facades\FortnoxAuthenticator;

FortnoxAuthenticator::routes();
```

Navigate to the `fortnox.oauth.authorize` route to start the authorization process.  
Set the desired OAuth scopes as a comma-separated list in `FORTNOX_OAUTH_SCOPE`. You can find valid scope options [here](https://www.fortnox.se/developer/guides-and-good-to-know/scopes).

Upon successful authorization, users are redirected to the URL specified in `FORTNOX_REDIRECT_URL`. You can check the authentication status with `FortnoxAuthenticator::isAuthenticated()`.

### Using a Provided Refresh Token

If you already have a refresh token, you can authenticate directly using that token.

1. Obtain a refresh token by granting access to the integration through Fortnox's OAuth2 authorization code flow.
2. Use the authorization code to retrieve both an access token (valid for 1 hour) and a refresh token (valid for 30 days).

This package automatically refreshes the access token if a valid refresh token is available. **Note**: Each time the access token is renewed, a new refresh token is issued, valid for an additional 30 days.

To manually renew tokens, run:

```bash
php artisan fortnox:refresh
```

> **Important**: Both tokens are stored based on your chosen `FORTNOX_TOKEN_DRIVER` (cache, file, or session). Be mindful of this when clearing cache or switching storage drivers.

## Usage

This package follows Fortnox's naming conventions and operations as described in the [Fortnox Developer Guide](https://www.fortnox.se/developer/). Below are some examples:

### Retrieving Objects

#### Retrieve All Customers

```php
Fortnox::customers()->all();
```

#### Retrieve a Single Customer

```php
Fortnox::customers()->get('1234');
```

Additional usage instructions and supported operations will be added soon.

## Contributing

Contributions are welcome! Please feel free to submit pull requests or issues.

## License

This package is open-sourced software licensed under the [MIT License](LICENSE).
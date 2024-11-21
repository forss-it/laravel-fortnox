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
composer require Warbio/laravel-fortnox
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
use Warbio\Fortnox\Facades\FortnoxAuthenticator;

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

The Fortnox API Client for Laravel simplifies interacting with Fortnox's resources by following their naming conventions and operations, as outlined in the [Fortnox Developer Guide](https://www.fortnox.se/developer/).

Below are detailed examples showcasing how to use the package with common Fortnox operations. These examples use the `Customer` resource, but the same principles apply to other supported resources.

### Basic Structure

All API operations are accessible through the `Fortnox` facade, which organizes resources into logical namespaces. Each resource (e.g., `customers`, `invoices`, `orders`) provides methods for CRUD operations such as `all`, `get`, `create`, `update`, and `delete`. Some resources has additional operations. See the Developer Guide.


### Examples with the `Customer` Resource

#### Retrieve All Customers

Fetch all customer records, with optional filtering and pagination:

```php
use Warbio\Fortnox\Facades\Fortnox;

$customers = Fortnox::customers()->all([
    'filter' => 'Active', // Optional filters like 'Active' or 'Inactive'
    'limit' => 50,        // Limit the number of results
    'page' => 1,          // Specify the page for paginated results
]);

foreach ($customers as $customer) {
    echo $customer['Name'];
}
```

#### Retrieve a Single Customer

Retrieve details of a specific customer by their ID:

```php
$customer = Fortnox::customers()->get('1234');

echo $customer['Name']; // Outputs the customer's name
```

#### Create a Customer

Create a new customer with required fields and additional properties:

```php
$newCustomer = Fortnox::customers()->create([
    'Name' => 'John Doe',
    'Address1' => 'Kalles Gata 1',
    'City' => 'Stockholm',
    'ZipCode' => '12345',
    'Country' => 'Sweden',
]);

echo $newCustomer['CustomerNumber']; // Outputs the newly created customer's ID
```

#### Update a Customer

Modify an existing customer’s details by providing their ID and updated fields:

```php
$updatedCustomer = Fortnox::customers()->update('1234', [
    'Phone1' => '123456789',
    'Email' => 'john.doe@example.com',
]);

echo $updatedCustomer['Phone1']; // Outputs the updated phone number
```

#### Delete a Customer

Remove a customer by their ID. Use with caution, as this action is irreversible:

```php
Fortnox::customers()->delete('1234');

echo "Customer deleted successfully.";
```

### Error Handling

Handle potential errors gracefully using try-catch blocks:

```php
try {
    $customer = Fortnox::customers()->get('invalid-id');
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

### Working with Other Resources

The same approach can be applied to other Fortnox resources, such as `invoices`, `orders`, `articles`, etc. For instance:

#### Retrieve All Invoices

```php
$invoices = Fortnox::invoices()->all();
```

#### Create an Invoice

```php
$newInvoice = Fortnox::invoices()->create([
    'CustomerNumber' => '1234',
    'InvoiceRows' => [
        [
            'ArticleNumber' => 'A1',
            'DeliveredQuantity' => 5,
            'Price' => 100,
        ],
    ],
]);
```

### Handling Attachments
The Fortnox API Client also allows you to upload and manage attachments. This can be particularly useful when working with invoices, orders, or other resources that require supporting documents. Below is a generalized example of creating a supplier invoice, uploading an attachment (e.g., a PDF), and linking the attachment to the invoice.

#### Example on how to add an attachment to a supplier invoice
```php
use Warbio\Fortnox\Facades\Fortnox;

// Step 1: Create the Supplier Invoice
$supplierInvoice = Fortnox::supplierInvoices()->create([
    'SupplierNumber' => '12345',
    'InvoiceDate' => now()->format('Y-m-d'),
    'DueDate' => now()->addDays(30)->format('Y-m-d'),
    'TotalAmount' => 5000,
    'Currency' => 'SEK',
]);

// Retrieve the Invoice Number from the response
$supplierInvoiceNumber = $supplierInvoice['SupplierInvoice']['InvoiceNumber'];

// Upload the File to the Fortnox Inbox
$uploadedFile = Fortnox::inbox()->upload('my_invoice.pdf', file_get_contents('/path/to/pdf'), 'inbox_s');

// Retrieve the File ID from the response
$fileId = $uploadedFile['File']['Id'];

// Link the Uploaded File to the Supplier Invoice
Fortnox::supplierInvoiceFileConnections()->create([
    'SupplierInvoiceFileConnection' => [
        'SupplierInvoiceNumber' => $supplierInvoiceNumber,
        'FileId' => $fileId,
    ],
]);

```


### Token Management

This package handles token management automatically based on your configured `FORTNOX_TOKEN_DRIVER`. It is recommended to schedule the token to refresh daily.

To refresh tokens manually:

```bash
php artisan fortnox:refresh
```


For token-related operations, use the `FortnoxAuthenticator` facade:

- Check authentication status:  
  ```php
  if (FortnoxAuthenticator::isAuthenticated()) {
      echo "Authenticated successfully!";
  }
  ```

- Manually revoke tokens:  
  ```php
  FortnoxAuthenticator::revoke();
  ```

## Contributing

Contributions are welcome! Please feel free to submit pull requests or issues.

## License

This package is open-sourced software licensed under the [MIT License](LICENSE).

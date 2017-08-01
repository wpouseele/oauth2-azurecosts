# DigitAzure Costs  Provider for OAuth 2.0 Client
[![Latest Version](https://img.shields.io/github/release/wpouseele/oauth2-azurecosts.svg?style=flat-square)](https://github.com/wpouseele/oauth2-azurecosts/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/wpouseelehemmingsazurecosts/master.svg?style=flat-square)](https://travis-ci.org/wpouseele/oauth2-azurecosts
wpouseele)
[![Quality Score](https://img.shields.io/scrutinizer/g/wpouseele/oauth2-azurecosts.svg?style=flat-square)](https://scrutinizer-ci.com/g/wpouseele/oauth2-azurecosts)
[![Total Downloads](https://img.shields.io/packagist/dt/wpouseele/oauth2-azurecosts.svg?style=flat-square)](https://packagist.org/packages/wpouseele/oauth2-azurecosts)


This package provides Azure Costs OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

To install, use composer:

```
composer require wpouseele/oauth2-azurecosts
```

## Usage

Usage is the same as The League's OAuth client, using `\WPouseele\OAuth2\Client\Provider\AzureCosts` as the provider.

### Authorization Code Flow

```php

require_once('./vendor/autoload.php');
session_start();

$provider = new \WPouseele\OAuth2\Client\Provider\AzureCosts([
    'clientId'          => '{azurecosts-client-id}',
    'clientSecret'      => '{azurecosts-client-secret}',
    'redirectUri'       => 'https://example.com/callback-url',
]);

if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the user's details
        $user = $provider->getResourceOwner($token);

        // Use these details to create a new profile
        printf('Hello %s!', $user->getName());

    } catch (Exception $e) {

        // Failed to get user details
        exit('Oh dear...');
    }

    // Use this to interact with an API on the users behalf
    echo $token->getToken();
}

```

## Laravel Framework Integration

This package includes Laravel framework integration if you need it. Simply require it as normal in your Laravel application,
and add the Service Provider `WPouseele\OAuth2\Client\FrameworkIntegration\Laravel\AzureCostsOAuth2ServiceProvider` to your `config/app.php`.

Next, publish the configuration with `php artisan vendor:publish --tag=oauth2-azurecosts`, and fill out your client
details in the `config/oauth2-azurecosts/config.php` file that is generated.

This will register bindings in the IoC container for the AzureCosts Provider, so you can simply typehint the
`\WPouselee\OAuth2\Client\Provider\AzureCosts` in your controller methods and it will yield a properly configured
instance.


## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/wpouseele/oauth2-azurecosts/blob/master/CONTRIBUTING.md) for details.

## Credits

- [Wim Pouseele](https://github.com/wpouseele)
- [All Contributors](https://github.com/wpouseele/oauth2-azurecosts/contributors)


## License

The MIT License (MIT). Please see [License File](https://github.com/wpouseele/oauth2-azurecosts/blob/master/LICENSE) for more information.

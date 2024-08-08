# test

[![Latest Version on Packagist](https://img.shields.io/packagist/v/solutionforest/filament-advanced-fields.svg?style=flat-square)](https://packagist.org/packages/solutionforest/filament-advanced-fields)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/solutionforest/filament-advanced-fields/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/solutionforest/filament-advanced-fields/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/solutionforest/filament-advanced-fields/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/solutionforest/filament-advanced-fields/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/solutionforest/filament-advanced-fields.svg?style=flat-square)](https://packagist.org/packages/solutionforest/filament-advanced-fields)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require solutionforest/filament-advanced-fields
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-advanced-fields-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-advanced-fields-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-advanced-fields-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$filamentAdvancedFields = new Solutionforest\FilamentAdvancedFields();
echo $filamentAdvancedFields->echoPhrase('Hello, Solutionforest!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [alan](https://github.com/solutionforest)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

# Laravel package to record events in Apiation

[//]: # ()
[//]: # ([![Latest Version on Packagist]&#40;https://img.shields.io/packagist/v/apiation/laravel.svg?style=flat-square&#41;]&#40;https://packagist.org/packages/apiation/laravel&#41;)

[//]: # ([![GitHub Tests Action Status]&#40;https://img.shields.io/github/actions/workflow/status/apiation/laravel/run-tests.yml?branch=main&label=tests&style=flat-square&#41;]&#40;https://github.com/apiation/laravel/actions?query=workflow%3Arun-tests+branch%3Amain&#41;)

[//]: # ([![GitHub Code Style Action Status]&#40;https://img.shields.io/github/actions/workflow/status/apiation/laravel/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square&#41;]&#40;https://github.com/apiation/laravel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain&#41;)

[//]: # ([![Total Downloads]&#40;https://img.shields.io/packagist/dt/apiation/laravel.svg?style=flat-square&#41;]&#40;https://packagist.org/packages/apiation/laravel&#41;)

[//]: # ()


## Installation

You can install the package via composer:

```bash
composer require apiation/laravel
```

Add the following ENV variables to your .env file:
```dotenv
APIATION_TOKEN=YOUR-TOKEN-HERE
APIATION_SAMPLE_RATE=0.03
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-config"
```

This is the contents of the published config file:

```php
return [
    'token' => env('APIATION_TOKEN'),

    // Whether the API call should be made asynchronously
    'async' => true,

//     To optimize performance you can queue the API call. To do so you can make an array and enter the desired queue and connection you want to push the job on.
//        'queue' => [
//        'queue' => '',
//        'connection' => ''
//    ],
//     If you want to use the default queue settings you can do the following:
//     'queue' => true,
//     Alternatively, if you don't want to utilize the queue, leave the value null
    'queue' => null,


    'sample_rate' => env('APIATION_SAMPLE_RATE', 0.03),
];
```

## Usage
You should add Apiation's middleware to your api middleware group within your application's app/Http/Kernel.php file
```php
'api' => [
    //\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
    \Apiation\ApiationLaravel\Http\Middleware\ApiationMiddleware::class,
],
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Samir Nijenhuis](https://github.com/apiation)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

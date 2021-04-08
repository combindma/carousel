# This is my package Carousel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/combindma/carousel.svg?style=flat-square)](https://packagist.org/packages/combindma/carousel)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/combindma/carousel/run-tests?label=tests)](https://github.com/combindma/carousel/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/combindma/carousel/Check%20&%20fix%20styling?label=code%20style)](https://github.com/combindma/carousel/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/combindma/carousel.svg?style=flat-square)](https://packagist.org/packages/combindma/carousel)

## Installation

You can install the package via composer:

```bash
composer require combindma/carousel
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Combindma\Carousel\CarouselServiceProvider" --tag="carousel-migrations"
php artisan migrate
```


## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Combind](https://github.com/combindma)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

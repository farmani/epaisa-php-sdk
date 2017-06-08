# ePaisa PHP SDK

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

## Install

The recommended way to install ePaisa PHP SDK is through [Composer](http://getcomposer.org/).

# Install Composer
``` bash
$ curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of ePaisa PHP SDK:

``` bash
$ php composer.phar require guzzlehttp/guzzle
```

After installing, you need to require Composer's autoloader:

``` php
require 'vendor/autoload.php';
```

You can then later update ePaisa PHP SDK using composer:

``` bash
$ php composer.phar update
```

## Usage

``` php
try {
    $ePaisa = new \eigitallabs\ePaisa\ePaisa('TOKEN');
    $payment = $ePaisa->createPayment();
    $list = $payment->listPayments();
    print_r($list);
} catch (\eigitallabs\ePaisa\Exception\ePaisaException $ex) {
    echo $ex->getMessage();
}
```
Please change TOKEN with proper value. you can get your token through ePaisa web panel.
you can see a list of available method via [DOCUMENTATION](DOCUMENTATION.md)

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email ramin.farmani@eigital.com instead of using the issue tracker.

## Credits

- [Ramin Farmani][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/eigitallabs/epaisa-php-sdk.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/eigitallabs/epaisa-php-sdk/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/eigitallabs/epaisa-php-sdk.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/eigitallabs/epaisa-php-sdk.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/eigitallabs/epaisa-php-sdk.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/eigitallabs/epaisa-php-sdk
[link-travis]: https://travis-ci.org/eigitallabs/epaisa-php-sdk
[link-scrutinizer]: https://scrutinizer-ci.com/g/eigitallabs/epaisa-php-sdk/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/eigitallabs/epaisa-php-sdk
[link-downloads]: https://packagist.org/packages/eigitallabs/epaisa-php-sdk
[link-author]: https://github.com/farmani-eigital
[link-contributors]: ../../contributors

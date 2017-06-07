# ePaisa PHP SDK Documents

## Install

Via Composer

``` bash
$ composer require eigitallabs/epaisa-php-sdk
```

## Basic Usage

``` php
$skeleton = new eigitallabs\ePaisa(TOKEN);
$paymentList = $skeleton->getPaymentList();
```
Please change TOKEN with proper value. you can get your token through ePaisa web panel.
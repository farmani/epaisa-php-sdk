## Basic Usage

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
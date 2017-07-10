## Partner

ePaisa PHP SDK provide you different object to communicate with ePaisa 2.0 REST API.

### get a list of merchants
``` php
try {
    $ePaisa = new \eigitallabs\ePaisa\ePaisa('TOKEN');
    $payment = $ePaisa->createPartner();
    $result = $payment->merchants($options);
    print_r($result);
} catch (\eigitallabs\ePaisa\Exception\ePaisaException $ex) {
    echo $ex->getMessage();
}
```
`$options` is an array and should contain all mandatory and optional fields you need to call `/partner/merchant` api.
please refer to REST api documentation to find more information about it.

### get a list of merchant's products
``` php
try {
    $ePaisa = new \eigitallabs\ePaisa\ePaisa('TOKEN');
    $payment = $ePaisa->createPartner();
    $result = $payment->products($options);
    print_r($result);
} catch (\eigitallabs\ePaisa\Exception\ePaisaException $ex) {
    echo $ex->getMessage();
}
```
`$options` is an array and should contain all mandatory and optional fields you need to call `/partner/merchant/product` api.
please refer to REST api documentation to find more information about it.
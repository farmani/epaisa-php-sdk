## Payment

ePaisa PHP SDK provide you different object to communicate with ePaisa 2.0 REST API.

### Initiate a payment
``` php
try {
    $ePaisa = new \eigitallabs\ePaisa\ePaisa('TOKEN');
    $payment = $ePaisa->createPayment();
    $result = $payment->initiate($options);
    print_r($result);
} catch (\eigitallabs\ePaisa\Exception\ePaisaException $ex) {
    echo $ex->getMessage();
}
```
`$options` is an array and should contain all mandatory and optional fields you need to call `/payment/initiate` api.
please refer to REST api documentation to find more information about it.

### Process a payment
``` php
try {
    $ePaisa = new \eigitallabs\ePaisa\ePaisa('TOKEN');
    $payment = $ePaisa->createPayment();
    $result = $payment->process($options);
    print_r($result);
} catch (\eigitallabs\ePaisa\Exception\ePaisaException $ex) {
    echo $ex->getMessage();
}
```
`$options` is an array and should contain all mandatory and optional fields you need to call `/payment/process` api.
please refer to REST api documentation to find more information about it.

### Authenticate a payment
``` php
try {
    $ePaisa = new \eigitallabs\ePaisa\ePaisa('TOKEN');
    $payment = $ePaisa->createPayment();
    $result = $payment->authenticate($options);
    print_r($result);
} catch (\eigitallabs\ePaisa\Exception\ePaisaException $ex) {
    echo $ex->getMessage();
}
```
`$options` is an array and should contain all mandatory and optional fields you need to call `/payment/authenticate` api.
please refer to REST api documentation to find more information about it.

### Update a payment
``` php
try {
    $ePaisa = new \eigitallabs\ePaisa\ePaisa('TOKEN');
    $payment = $ePaisa->createPayment();
    $result = $payment->update($options);
    print_r($result);
} catch (\eigitallabs\ePaisa\Exception\ePaisaException $ex) {
    echo $ex->getMessage();
}
```
`$options` is an array and should contain all mandatory and optional fields you need to call `/payment/update` api.
please refer to REST api documentation to find more information about it.

### Finalize a payment
``` php
try {
    $ePaisa = new \eigitallabs\ePaisa\ePaisa('TOKEN');
    $payment = $ePaisa->createPayment();
    $result = $payment->finalize($options);
    print_r($result);
} catch (\eigitallabs\ePaisa\Exception\ePaisaException $ex) {
    echo $ex->getMessage();
}
```
`$options` is an array and should contain all mandatory and optional fields you need to call `/payment/finalize` api.
please refer to REST api documentation to find more information about it.

### List payments
``` php
try {
    $ePaisa = new \eigitallabs\ePaisa\ePaisa('TOKEN');
    $payment = $ePaisa->createPayment();
    $result = $payment->listPayments($options);
    print_r($result);
} catch (\eigitallabs\ePaisa\Exception\ePaisaException $ex) {
    echo $ex->getMessage();
}
```
`$options` is an array and should contain all mandatory and optional fields you need to call `/payment/list` api.
please refer to REST api documentation to find more information about it.

### Details of a payment
``` php
try {
    $ePaisa = new \eigitallabs\ePaisa\ePaisa('TOKEN');
    $payment = $ePaisa->createPayment();
    $result = $payment->details($options);
    print_r($result);
} catch (\eigitallabs\ePaisa\Exception\ePaisaException $ex) {
    echo $ex->getMessage();
}
```
`$options` is an array and should contain all mandatory and optional fields you need to call `/payment/details` api.
please refer to REST api documentation to find more information about it.

### Void a payment
``` php
try {
    $ePaisa = new \eigitallabs\ePaisa\ePaisa('TOKEN');
    $payment = $ePaisa->createPayment();
    $result = $payment->void($options);
    print_r($result);
} catch (\eigitallabs\ePaisa\Exception\ePaisaException $ex) {
    echo $ex->getMessage();
}
```
`$options` is an array and should contain all mandatory and optional fields you need to call `/payment/void` api.
please refer to REST api documentation to find more information about it.

### Cancel a payment
``` php
try {
    $ePaisa = new \eigitallabs\ePaisa\ePaisa('TOKEN');
    $payment = $ePaisa->createPayment();
    $result = $payment->cancel($options);
    print_r($result);
} catch (\eigitallabs\ePaisa\Exception\ePaisaException $ex) {
    echo $ex->getMessage();
}
```
`$options` is an array and should contain all mandatory and optional fields you need to call `/payment/cancel` api.
please refer to REST api documentation to find more information about it.

### Fetch the receipt
``` php
try {
    $ePaisa = new \eigitallabs\ePaisa\ePaisa('TOKEN');
    $payment = $ePaisa->createPayment();
    $result = $payment->receipt($options);
    print_r($result);
} catch (\eigitallabs\ePaisa\Exception\ePaisaException $ex) {
    echo $ex->getMessage();
}
```
`$options` is an array and should contain all mandatory and optional fields you need to call `/receipt` api.
please refer to REST api documentation to find more information about it.
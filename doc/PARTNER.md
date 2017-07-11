## Partner

ePaisa PHP SDK provide you different object to communicate with ePaisa 2.0 REST API.

### List of merchants
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

``` php
Array
(
    [Merchants] => Array
        (
            [0] => Array
                (
                    [merchantId] => 2734
                    [parentId] => 472
                    [planId] => 1
                    [businessTypeId] => 0
                    [countryCode] => IN
                    [stateId] => 0
                    [cityId] => 0
                    [areaId] => 0
                    [merchantCompanyName] => test999
                    [merchantPANCode] => 
                    [merchantYearlyRevenue] => 0
                    [merchantAllowedUser] => 1
                    [merchantTransactionStatus] => ACTIVE
                    [merchantSignupSource] => 
                    [createdUserId] => 0
                    [updatedUserId] => 0
                    [created_at] => 1489496907
                    [updated_at] => 1489496907
                    [status] => 1
                    [planExpiryDate] => 
                    [industryId] => 
                    [categoryId] => 
                )

            [1] => Array
                (
                    [merchantId] => 2807
                    [parentId] => 472
                    [planId] => 1
                    [businessTypeId] => 6
                    [countryCode] => 
                    [stateId] => 0
                    [cityId] => 0
                    [areaId] => 0
                    [merchantCompanyName] => 34343
                    [merchantPANCode] => 
                    [merchantYearlyRevenue] => 0
                    [merchantAllowedUser] => 1
                    [merchantTransactionStatus] => ACTIVE
                    [merchantSignupSource] => 
                    [createdUserId] => 0
                    [updatedUserId] => 0
                    [created_at] => 1493967496
                    [updated_at] => 1493967533
                    [status] => 1
                    [planExpiryDate] => 
                    [industryId] => 2
                    [categoryId] => 
                )
                
        )

    [total] => 2
)
```
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
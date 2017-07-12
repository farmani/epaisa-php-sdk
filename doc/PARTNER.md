## Partner

ePaisa PHP SDK provide you different object to communicate with ePaisa 2.0 REST API.

### List of merchants
``` php
try {
    $ePaisa = new \eigitallabs\ePaisa\ePaisa('TOKEN');
    $payment = $ePaisa->createPartner();
    $options = ['merchantIds' => [4353,6545]];
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
    [success] => 1
    [response] => Array
        (
            [Merchants] => Array
                (
                    [0] => Array
                        (
                            [merchantId] => 4353
                            [address] =>  
                            [cityName] => 
                            [stateName] => 
                            [pincode] => 
                            [merchantCompanyName] => test999
                            [status] => 
                            [email] => test@133.com
                            [mobile] => +919887884898
                        )

                    [1] => Array
                        (
                            [merchantId] => 6545
                            [address] =>  
                            [cityName] => Mumbai
                            [stateName] => Maharashtra
                            [pincode] => 
                            [merchantCompanyName] => ePaisa
                            [status] => 
                            [email] => mrfarmani@gmail.com
                            [mobile] => 989153023376
                        )
                )

            [total] => 2
        )

)
```
### get a list of merchant's products
``` php
try {
    $ePaisa = new \eigitallabs\ePaisa\ePaisa('TOKEN');
    $payment = $ePaisa->createPartner();
    $options = [
        'merchantId' => 4353,
        'productId' => '59645d891d41c80b3c59eb63'
    ];
    $result = $payment->products($options);
    print_r($result);
} catch (\eigitallabs\ePaisa\Exception\ePaisaException $ex) {
    echo $ex->getMessage();
}
```
`$options` is an array and should contain all mandatory and optional fields you need to call `/partner/merchant/product` api.
please refer to REST api documentation to find more information about it.
``` php
Array
(
    [success] => 1
    [response] => Array
        (
            [Products] => Array
                (
                    [0] => Array
                        (
                            [productName] => Test Product Name
                            [description] => a shor description to explain product details.
                            [productId] => 59645d891d41c80b3c59eb63
                            [imageUrl] => Test Product Name
                            [variants] => Array
                                (
                                    [0] => Array
                                        (
                                            [name] => 
                                            [upc] => 
                                            [sku] => spt-12345
                                            [sellingPrice] => 150
                                            [buyingPrice] => 140
                                            [mrp] => 160
                                            [discount] => 5
                                            [discountType] => %
                                            [inventory] => 0
                                            [threshold] => 0
                                            [productId] => 59645d891d41c80b3c59eb63
                                            [merchantId] => 2784
                                            [createdUserId] => 2734
                                            [updatedUserId] => 2734
                                            [created_at] => 1499749769
                                            [updated_at] => 1499749769
                                            [status] => 1
                                            [variantId] => 59645d891d41c80b3c59eb64
                                        )

                                )

                            [taxes] => Array
                                (
                                )

                            [manufacturers] => Array
                                (
                                )

                        )

                )

            [total] => 1
        )

)
```
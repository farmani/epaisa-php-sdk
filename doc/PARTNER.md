# Partner Module

ePaisa PHP SDK provide you different object to communicate with ePaisa 2.0 Partner Module REST API.

* [List of merchants](https://github.com/eigitallabs/epaisa-php-sdk/blob/master/doc/PARTNER.md#list-of-merchants)
  * [$options parameters for List of merchants](https://github.com/eigitallabs/epaisa-php-sdk/blob/master/doc/PARTNER.md#options-parameters) 
* [List of products](https://github.com/eigitallabs/epaisa-php-sdk/blob/master/doc/PARTNER.md#list-of-products)
  * [$options parameters for List of products](https://github.com/eigitallabs/epaisa-php-sdk/blob/master/doc/PARTNER.md#options-parameters-1) 
## List of merchants
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
`$options` is an array and should contain all mandatory and optional fields you need to call `/v2.0/partner/merchant` api.
please refer to REST api documentation to find more information about it.

### $options parameters
* <p><b><i>merchantId</i></b> - <i>Integer</i> fetch a specific merchant information. <u>Optional</u></p>
* <p><b><i>merchantIds</i></b> - <i>Array of Integer</i> fetch a list of specific merchants. <u>Optional</u></p>
* <p><b><i>updated_at</i></b> - <i>Integer</i> to reduce response size or number of request you can send updated_at values which is most recent updated_at values you received in your previous requests, we will filter merchants which has some new changes after this timestamp value. <u>Optional</u></p>
* <p><b><i>limit</i></b> - <i>Integer</i> number of item in result list. <u>Optional</u></p>
* <p><b><i>offset</i></b> - <i>Integer</i> offset of item in result list. <u>Optional</u></p>

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
## List of products
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
`$options` is an array and should contain all mandatory and optional fields you need to call `/v2.0/partner/merchant/product` api.
please refer to REST api documentation to find more information about it.

### $options parameters
* <p><b><i>merchantId</i></b> - <i>Integer</i> if you want to fetch all products under a specific merchant you can set merchantId. <u>Optional</u></p>
* <p><b><i>merchantIds</i></b> - <i>Array of Integers</i> if you want to fetch all products under a some merchants you can set merchantIds. <u>Optional</u></p>
* <p><b><i>productId</i></b> - <i>String</i> if you want to fetch a product under a specific merchant you can set productId and merchantId. <u>Optional</u></p>
* <p><b><i>productIds</i></b> - <i>Array of String</i> if you want to fetch some products under a specific merchant or some different merchants you can set productIds and merchantId or merchantIds. <u>Optional</u></p>
* <p><b><i>productName</i></b> - <i>String</i> you can search throught product names and get a list of similar name products. <u>Optional</u></p>
* <p><b><i>categories</i></b> - <i>String</i> products in ePaisa 2 belong to one or more parent category and/or one or more parent and child categories, categories use an unlimited parent/child hierarchy mechanism, if you send a category name string as categories parameter we will filter products for that parent or child category. <u>Optional</u></p>
* <p><b><i>manufacturers</i></b> - <i>String</i> you can search throught products manufactured by a manufaturer. <u>Optional</u></p>
* <p><b><i>updated_at</i></b> - <i>Integer</i> to reduce response size or number of request you can send updated_at values which is most recent updated_at values you received in your previous requests, we will filter products which has some new changes after this timestamp value. <u>Optional</u></p>
* <p><b><i>limit</i></b> - <i>Integer</i> number of item in result list. <u>Optional</u></p>
* <p><b><i>offset</i></b> - <i>Integer</i> offset of item in result list. <u>Optional</u></p>

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
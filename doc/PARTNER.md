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
                            [productDisplayName] => Test Product Name
                            [productDescription] => a shor description to explain product details.
                            [storeLocationId] => 2298
                            [categories] => Array
                                (
                                    [0] => Uncategorized
                                )

                            [manufacturers] => Array
                                (
                                )

                            [distributors] => Array
                                (
                                )

                            [isAddon] => 
                            [attributes] => Array
                                (
                                )

                            [taxes] => Array
                                (
                                )

                            [merchantId] => 2784
                            [updatedUserId] => 2734
                            [createdUserId] => 2734
                            [storeLocationCaption] => Headquarters
                            [created_at] => 1499749769
                            [updated_at] => 1499749769
                            [status] => 1
                            [productName] => headquarters_test_product_name
                            [productId] => 59645d891d41c80b3c59eb63
                            [storeLocation] => Headquarters
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

                            [parentCategories] => Array
                                (
                                    [0] => Array
                                        (
                                            [productCategoryId] => 1346
                                            [parentProductCategoryId] => 
                                            [productCategoryName] => Uncategorized
                                            [status] => 1
                                            [createdUserId] => 2734
                                            [updatedUserId] => 2734
                                            [created_at] => 1499749769
                                            [updated_at] => 1499749769
                                            [merchantId] => 2784
                                            [productCategoryColor] => #FFFFFF
                                        )

                                )

                        )

                )

            [total] => 1
        )

)
```
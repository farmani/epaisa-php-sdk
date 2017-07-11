## User

ePaisa PHP SDK provide you different object to communicate with ePaisa 2.0 REST API.

### register a new user
``` php
try {
    $ePaisa = new \eigitallabs\ePaisa\ePaisa('TOKEN');
    $payment = $ePaisa->createUser();
    $options = [
        'UserFirstName' => 'Ramin',
        'UserLastName' => 'Farmani',
        'Username' => 'a_test_email@gmail.com',
        'Password' => '1qaz3edc%TGB',
        'UserMobileNumber' => '+91123456789',
        'CountryCode' => 'IN',
        'CompanyPANCode => '',
        'parentMerchantId' => 472
    ];
    $result = $payment->register($options);
    print_r($result);
} catch (\eigitallabs\ePaisa\Exception\ePaisaException $ex) {
    echo $ex->getMessage();
}
```

`$options` is an array and should contain all mandatory and optional fields you need to call `/user/register` api.
please refer to REST api documentation to find more information about it.

``` php
Array
(
    [success] => 1
    [message] => Thank you for the registering with ePaisa.
    [response] => Array
        (
            [id] => 3053
            [roleId] => 2
            [rolePlan] => 
            [userRole] => Merchant Admin
            [storeAddress] => __
            [storeAddress2] => 
            [storeStateName] => 
            [storeCityName] => 
            [storePincode] => 
            [username] => a_test_email@gmail.com
            [merchantId] => 3068
            [storeLocationId] => 2642
            [auth_key] => X2lKZ0E5JM6KkcII5IFAtlFPQpJljVAQ5ZfwXpv2cIFCMBiReGLTiL9GyHQsIfkt
            [auth_key_creationtime] => 1499775205
            [userMobileNumber] => +91123456989
            [userFirstName] => Ramin
            [userMiddleName] => 
            [userLastName] => Farmani
            [userImage] => 
            [cityId] => 0
            [stateId] => 0
            [pincode] => 
            [countryCode] => IN
            [userAddress1] => 
            [userAddress2] => 
            [userIMEI] => 
            [userPanNumber] => 
            [userAppVersion] => 1
            [dateOfBirth] => 
            [status] => 1
            [created_at] => 1499775205
            [updated_at] => 1499775205
            [loginAttempt] => 
            [pubsubToken] => e8a917317871abf584c0df0cec935bff
        )

    [merchant] => Array
        (
            [merchantId] => 3068
            [parentId] => 
            [planId] => 1
            [businessTypeId] => 0
            [countryCode] => IN
            [stateId] => 0
            [cityId] => 0
            [areaId] => 0
            [merchantCompanyName] => 
            [merchantPANCode] => 0
            [merchantYearlyRevenue] => 0
            [merchantAllowedUser] => 
            [createdUserId] => 0
            [updatedUserId] => 0
            [created_at] => 1499775205
            [updated_at] => 1499775205
            [status] => 
            [planExpiryDate] => 
            [industryId] => 
            [categoryId] => 
            [subCategories] => Array
                (
                )

        )

)
```
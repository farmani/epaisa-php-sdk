<?php
/**
 * This file is part of the epaisa-php-sdk package.
 *
 * (c) Ramin Farmani <ramin.farmani@eigital.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace eigitallabs\ePaisa\Tests\Unit;

use eigitallabs\ePaisa\Exception\ePaisaLogException;
use eigitallabs\ePaisa\Log;
use eigitallabs\ePaisa\Payment;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * @package         ePaisaTest
 * @author          Ramin Farmani <ramin.farmani@eigital.com>
 * @copyright       eigitallabs
 * @license         http://opensource.org/licenses/mit-license.php  The MIT License (MIT)
 * @link            https://github.com/eigitallabs/epaisa-php-sdk
 */
class PaymentTest extends TestCase
{
    /**
     * @var \eigitallabs\ePaisa\Payment
     */
    private $payment;

    private $cancelPaymentId = null;
    private $voidPaymentId = null;
    private $finalizePaymentId = null;

    public function setUp()
    {
        $ePaisa = new \eigitallabs\ePaisa\ePaisa('pztfgMmPHTARiVZkKVjoj1oUxdUKP01Dnr76QtgEQnGO1pAl8QzTHYiQe2qeUJi2Ew7KIKcEaVVpt4JPnHuAe0HTgmxKOqRz88mvhBAp5uLwfZV11GEOVZk4Plmj0HZI');
        $this->payment = $ePaisa->createPayment();
    }

    public function tearDown()
    {
        $this->payment = null;
    }

    public function testListPayments()
    {
        $result = $this->payment->listPayments([
            'include' => ['transactions','history','transactions_history','orders'],
        ]);
        $this->assertArrayHasKey('success', $result, "Unexpected response from server!");
        $this->assertEquals(1, $result['success'], json_encode($result));
        foreach ($result['response'] as $item) {
            if(isset($item['paymentStatusId']) && $item['paymentStatusId'] == 1) {
                $this->payment->cancel(['paymentId'=>$item['paymentId']]);
                continue;
            }

            if(empty($_SESSION['cancelPaymentId']) && !empty($item['paymentId']))
                $_SESSION['cancelPaymentId'] = $item['paymentId'];
            if(!empty($_SESSION['cancelPaymentId']) && empty($_SESSION['voidPaymentId']) && !empty($item['paymentId']))
                $_SESSION['voidPaymentId'] = $item['paymentId'];
        }
    }

    public function testCancel()
    {
        $result = $this->payment->cancel(['paymentId'=>$_SESSION['cancelPaymentId']]);
        $this->assertArrayHasKey('success', $result, "Unexpected response from server!");
        $this->assertEquals(1, $result['success'], json_encode($result));
    }

    public function testVoid()
    {
        $result = $this->payment->void(['paymentId'=>$_SESSION['voidPaymentId']]);
        $this->assertArrayHasKey('success', $result, "Unexpected response from server!");
        $this->assertEquals(1, $result['success'], json_encode($result));
    }

    public function testInitiate()
    {
        $options = json_decode('{
  "paymentCurrencyId": 25,
  "paymentAmount": "100.00",
  "paymentTipAmount": 0,
  "paymentSubTotal": 0,
  "paymentTotalDiscount": 0,
  "paymentCustomerId": "",
  "location": "19.0636695,72.8338119,",
  "customerId": 1,
  "customFieldArray": [
    {
      "fieldName": "Doctor Id",
      "fieldValue": "76543"
    }
  ],
  "order": {
    "customItems": [
      {
        "name": "cellphone",
        "unitPrice": "40.00",
        "quantity": "3",
        "calculatedPrice": "120.00",
        "discount": "10.00",
        "calculatedDiscount": "36.00",
        "basePrice": "1200 / 5"
      }
    ],
    "subTotal": "568.00",
    "totalPrice": "580.00",
    "totalTax": "0",
    "totalDiscount": "10",
    "generalDiscount": "general discount applied to cart",
    "roundOffAmount": "amount thats rounded if enabled",
    "serviceCharges": "10.00",
    "deliveryCharges": "50.00"
  }
}', true);
        $result = $this->payment->initiate($options);
        if(isset($result['paymentId'])) {
            $this->finalizePaymentId = $result['paymentId'];
        }
        $this->assertArrayHasKey('success', $result, "Unexpected response from server!");
        $this->assertEquals(1, $result['success'], json_encode($result));
    }

    public function testProcess()
    {
        $result = $this->payment->process([
            'paymentId'             => $this->finalizePaymentId,
            'transactionTypeId'     => 1,
            'transactionCurrencyId' => 25,
            'transactionAmount'     => '100.00',
            'mobileNumber'          => '+989153023386',
            'additional'            => '',
        ]);
        $this->assertArrayHasKey('success', $result, "Unexpected response from server!");
        $this->assertEquals(1, $result['success'], json_encode($result));
    }

    public function testFinalize()
    {
        $result = $this->payment->finalize(['paymentId' => $this->finalizePaymentId]);
        $this->assertArrayHasKey('success', $result, "Unexpected response from server!");
        $this->assertEquals(1, $result['success'], json_encode($result));
    }

    public function testReceipt()
    {
        $result = $this->payment->receipt(['email'=>'ramin.farmani@gmail.com', 'paymentId' => $this->paymentId]);
        $this->assertArrayHasKey('success', $result, "Unexpected response from server!");
        $this->assertEquals(1, $result['success'], json_encode($result));
    }

    public function testDetails()
    {
        $result = $this->payment->details();
        $this->assertArrayHasKey('success', $result, "Unexpected response from server!");
        $this->assertEquals(1, $result['success'], json_encode($result));
    }

    public function testAuthenticate()
    {
        $result = $this->payment->authenticate();
        $this->assertArrayHasKey('success', $result, "Unexpected response from server!");
        $this->assertEquals(1, $result['success'], json_encode($result));
    }

    public function testUpdate()
    {
        $result = $this->payment->update();
        $this->assertArrayHasKey('success', $result, "Unexpected response from server!");
        $this->assertEquals(1, $result['success'], json_encode($result));
    }
}
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

/**
 * @package         ePaisaTest
 * @author          Ramin Farmani <ramin.farmani@eigital.com>
 * @copyright       eigitallabs
 * @license         http://opensource.org/licenses/mit-license.php  The MIT License (MIT)
 * @link            https://github.com/eigitallabs/epaisa-php-sdk
 */
class ProfileTest extends TestCase
{
    /**
     * @var \eigitallabs\ePaisa\Profile
     */
    private $profile;

    public function setUp()
    {
        $ePaisa = new \eigitallabs\ePaisa\ePaisa('PaYt4SZfu4bDAq6h4MHdqACJ8ifCDjjTXRAR4yMhKm2iuzszxKUwBhYV7Lwmb5b01s4xmFGRCnttOgtzoiQFQ51ZAwcgIEsoOWRbQOGRbZr0cxflnNwUKuQ2U7DNskDb');
        $this->profile = $ePaisa->createProfile();
    }

    public function tearDown()
    {
        $this->profile = null;
    }

    public function testView()
    {
        $result = $this->profile->view([
            'userId' => 459,
        ]);
        $this->assertArrayHasKey('success', $result, "Unexpected response from server!");
        $this->assertEquals(1, $result['success'], json_encode($result));
    }

    public function testUpdate()
    {
        $result = $this->profile->update([
            'userFirstName' => 'strange',
        ]);
        $this->assertArrayHasKey('success', $result, "Unexpected response from server!");
        $this->assertEquals(1, $result['success'], json_encode($result));
    }

}
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

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var string
     */
    public static $dummy_api_key = 'xq6UN8XsFebBH4UPD-7MD4OAzZ8ZdupLPcOU4xn8gfvvta5SPa4ui8lf4L6mlJ90';

    protected function skip64BitTest()
    {
        if (PHP_INT_SIZE === 4) {
            $this->markTestSkipped(
                'Skipping test that can run only on a 64-bit build of PHP.'
            );
        }
    }
}
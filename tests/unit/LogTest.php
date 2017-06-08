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
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * @package         ePaisaTest
 * @author          Ramin Farmani <ramin.farmani@eigital.com>
 * @copyright       eigitallabs
 * @license         http://opensource.org/licenses/mit-license.php  The MIT License (MIT)
 * @link            https://github.com/eigitallabs/epaisa-php-sdk
 */
class LogTest extends TestCase
{
    /**
     * @var array Dummy logfile paths
     */
    private static $logFiles = [
        'error'    => '/tmp/error.log',
        'debug'    => '/tmp/debug.log',
        'external' => '/tmp/php-telegram-bot-externallog.log',
    ];

    protected function tearDown()
    {
        // Make sure no logfiles exist.
        foreach (self::$logFiles as $file) {
            file_exists($file) && unlink($file);
        }
    }

    /**
     * @expectedException ePaisaLogException
     */
    public function testNewInstanceWithoutErrorPath()
    {
        Log::initErrorLog('');
    }

    /**
     * @expectedException ePaisaLogException
     */
    public function testNewInstanceWithoutDebugPath()
    {
        Log::initDebugLog('');
    }

    public function testErrorStream()
    {
        $file = self::$logFiles['error'];
        $this->assertFileNotExists($file);
        Log::initErrorLog($file);
        Log::error('my error');
        Log::error('my 50% error');
        Log::error('my %s error', 'placeholder');
        $this->assertFileExists($file);
        $error_log = file_get_contents($file);
        $this->assertContains('bot_log.ERROR: my error', $error_log);
        $this->assertContains('bot_log.ERROR: my 50% error', $error_log);
        $this->assertContains('bot_log.ERROR: my placeholder error', $error_log);
    }

    public function testDebugStream()
    {
        $file = self::$logFiles['debug'];
        $this->assertFileNotExists($file);
        Log::initDebugLog($file);
        Log::debug('my debug');
        Log::debug('my 50% debug');
        Log::debug('my %s debug', 'placeholder');
        $this->assertFileExists($file);
        $debug_log = file_get_contents($file);
        $this->assertContains('bot_log.DEBUG: my debug', $debug_log);
        $this->assertContains('bot_log.DEBUG: my 50% debug', $debug_log);
        $this->assertContains('bot_log.DEBUG: my placeholder debug', $debug_log);
    }

    public function testExternalStream()
    {
        $file = self::$logFiles['external'];
        $this->assertFileNotExists($file);
        $external_monolog = new Logger('bot_update_log');
        $external_monolog->pushHandler(new StreamHandler($file, Logger::ERROR));
        $external_monolog->pushHandler(new StreamHandler($file, Logger::DEBUG));
        Log::initialize($external_monolog);
        Log::error('my error');
        Log::error('my 50% error');
        Log::error('my %s error', 'placeholder');
        Log::debug('my debug');
        Log::debug('my 50% debug');
        Log::debug('my %s debug', 'placeholder');
        $this->assertFileExists($file);
        $file_contents = file_get_contents($file);
        $this->assertContains('bot_update_log.ERROR: my error', $file_contents);
        $this->assertContains('bot_update_log.ERROR: my 50% error', $file_contents);
        $this->assertContains('bot_update_log.ERROR: my placeholder error', $file_contents);
        $this->assertContains('bot_update_log.DEBUG: my debug', $file_contents);
        $this->assertContains('bot_update_log.DEBUG: my 50% debug', $file_contents);
        $this->assertContains('bot_update_log.DEBUG: my placeholder debug', $file_contents);
    }
}
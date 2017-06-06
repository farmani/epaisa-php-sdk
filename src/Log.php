<?php
/**
 * This file is part of the epaisa-php-sdk package.
 *
 * (c) Ramin Farmani <ramin.farmani@eigital.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace eigitallabs\ePaisa;

use eigitallabs\ePaisa\Exception\ePaisaLogException;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Log
{
    /**
     * Monolog instance
     *
     * @var \Monolog\Logger
     */
    static protected $monolog;
    /**
     * Monolog instance for update
     *
     * @var \Monolog\Logger
     */
    static protected $monologUpdate;
    /**
     * Path for error log
     *
     * @var string
     */
    static protected $errorLogPath;
    /**
     * Path for debug log
     *
     * @var string
     */
    static protected $debugLogPath;
    /**
     * Path for update log
     *
     * @var string
     */
    static protected $updateLogPath;
    /**
     * Temporary stream handle for debug log
     *
     * @var resource|null
     */
    static protected $debugLogTempStreamHandle;
    /**
     * Initialize
     *
     * Initialize monolog instance. Singleton
     * Is possible provide an external monolog instance
     *
     * @param \Monolog\Logger
     *
     * @return \Monolog\Logger
     */
    public static function initialize(Logger $external_monolog = null)
    {
        if (self::$monolog === null) {
            if ($external_monolog !== null) {
                self::$monolog = $external_monolog;
                foreach (self::$monolog->getHandlers() as $handler) {
                    if ($handler->getLevel() === 400) {
                        self::$errorLogPath = 'true';
                    }
                    if ($handler->getLevel() === 100) {
                        self::$debugLogPath = 'true';
                    }
                }
            } else {
                self::$monolog = new Logger('epaisa_php_sdk_log');
            }
        }
        return self::$monolog;
    }
    /**
     * Initialize error log
     *
     * @param string $path
     *
     * @return \Monolog\Logger
     * @throws \eigitallabs\ePaisa\Exception\ePaisaLogException
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public static function initErrorLog($path)
    {
        if ($path === null || $path === '') {
            throw new ePaisaLogException('Empty path for error log');
        }
        self::initialize();
        self::$errorLogPath = $path;
        return self::$monolog->pushHandler(
            (new StreamHandler(self::$errorLogPath, Logger::ERROR))
                ->setFormatter(new LineFormatter(null, null, true))
        );
    }
    /**
     * Initialize debug log
     *
     * @param string $path
     *
     * @return \Monolog\Logger
     * @throws \eigitallabs\ePaisa\Exception\ePaisaLogException
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public static function initDebugLog($path)
    {
        if ($path === null || $path === '') {
            throw new ePaisaLogException('Empty path for debug log');
        }
        self::initialize();
        self::$debugLogPath = $path;
        return self::$monolog->pushHandler(
            (new StreamHandler(self::$debugLogPath, Logger::DEBUG))
                ->setFormatter(new LineFormatter(null, null, true))
        );
    }
    /**
     * Get the stream handle of the temporary debug output
     *
     * @return mixed The stream if debug is active, else false
     */
    public static function getDebugLogTempStream()
    {
        if (self::$debugLogTempStreamHandle === null) {
            if (!self::isDebugLogActive()) {
                return false;
            }
            self::$debugLogTempStreamHandle = fopen('php://temp', 'w+b');
        }
        return self::$debugLogTempStreamHandle;
    }
    /**
     * Write the temporary debug stream to log and close the stream handle
     *
     * @param string $message Message (with placeholder) to write to the debug log
     */
    public static function endDebugLogTempStream($message = '%s')
    {
        if (is_resource(self::$debugLogTempStreamHandle)) {
            rewind(self::$debugLogTempStreamHandle);
            self::debug($message, stream_get_contents(self::$debugLogTempStreamHandle));
            fclose(self::$debugLogTempStreamHandle);
            self::$debugLogTempStreamHandle = null;
        }
    }
    /**
     * Initialize update log
     *
     * Initilize monolog instance. Singleton
     * Is possbile provide an external monolog instance
     *
     * @param string $path
     *
     * @return \Monolog\Logger
     * @throws \eigitallabs\ePaisa\Exception\ePaisaLogException
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public static function initUpdateLog($path)
    {
        if ($path === null || $path === '') {
            throw new ePaisaLogException('Empty path for update log');
        }
        self::$updateLogPath = $path;
        if (self::$monologUpdate === null) {
            self::$monologUpdate = new Logger('bot_update_log');
            // Create a formatter
            $output = '%message%' . PHP_EOL;
            $formatter = new LineFormatter($output);
            // Update handler
            $update_handler = new StreamHandler(self::$updateLogPath, Logger::INFO);
            $update_handler->setFormatter($formatter);
            self::$monologUpdate->pushHandler($update_handler);
        }
        return self::$monolog;
    }
    /**
     * Is error log active
     *
     * @return bool
     */
    public static function isErrorLogActive()
    {
        return self::$errorLogPath !== null;
    }
    /**
     * Is debug log active
     *
     * @return bool
     */
    public static function isDebugLogActive()
    {
        return self::$debugLogPath !== null;
    }
    /**
     * Is update log active
     *
     * @return bool
     */
    public static function isUpdateLogActive()
    {
        return self::$updateLogPath !== null;
    }
    /**
     * Report error log
     *
     * @param string $text
     */
    public static function error($text)
    {
        if (self::isErrorLogActive()) {
            $text = self::getLogText($text, func_get_args());
            self::$monolog->error($text);
        }
    }
    /**
     * Report debug log
     *
     * @param string $text
     */
    public static function debug($text)
    {
        if (self::isDebugLogActive()) {
            $text = self::getLogText($text, func_get_args());
            self::$monolog->debug($text);
        }
    }
    /**
     * Report update log
     *
     * @param string $text
     */
    public static function update($text)
    {
        if (self::isUpdateLogActive()) {
            $text = self::getLogText($text, func_get_args());
            self::$monologUpdate->info($text);
        }
    }
    /**
     * Applies vsprintf to the text if placeholder replacements are passed along.
     *
     * @param string $text
     * @param array  $args
     *
     * @return string
     */
    protected static function getLogText($text, array $args = [])
    {
        // Pop the $text off the array, as it gets passed via func_get_args().
        array_shift($args);
        // If no placeholders have been passed, don't parse the text.
        if (empty($args)) {
            return $text;
        }
        return vsprintf($text, $args);
    }
}
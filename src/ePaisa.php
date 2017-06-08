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

use eigitallabs\ePaisa\Exception\ePaisaException;

/**
 * Class ePaisa
 * @package eigitallabs\ePaisa
 */
class ePaisa
{
    /**
     * Version
     *
     * @var string
     */
    protected $version = '1.0.1';
    /**
     * ePaisa client
     *
     * @var \eigitallabs\ePaisa\Request
     */
    protected $client = null;
    /**
     * ePaisa merchant token
     *
     * @var string
     */
    public $token = null;

    /**
     * Create a new Skeleton Instance
     * @param $token
     * @throws ePaisaException
     * @internal param array $config
     */
    public function __construct($token)
    {
        $root = realpath(__DIR__ . DIRECTORY_SEPARATOR . '../');
        $dotEnv = new \Dotenv\Dotenv($root.'config/');
        $dotEnv->overload();
        $dotEnv->required(['CLIENT_ID', 'CLIENT_SECRET','API_URL','SOURCE_ID']);

        Log::initErrorLog($root . 'tmp/error.log');
        Log::initDebugLog($root . 'tmp/debug.log');
        $this->token = $token;
        $this->client = new Request($this);
    }

    /**
     * Get an instance of Payment object
     *
     * @return Payment
     */
    public function createPayment()
    {
        return new Payment($this->client);
    }

    /**
     * Get an instance of Profile object
     *
     * @return Profile
     */
    public function createProfile()
    {
        return new Profile($this->client);
    }
}

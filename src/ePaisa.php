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

class ePaisa
{
    /**
     * Version
     *
     * @var string
     */
    protected $version = '1.0.1';
    /**
     * ePaisa client id
     *
     * @var string
     */
    protected $clientId = '';
    /**
     * ePaisa client secret
     *
     * @var string
     */
    protected $secret = '';
    /**
     * ePaisa client
     *
     * @var \eigitallabs\ePaisa\Request
     */
    protected $client = null;

    /**
     * Create a new Skeleton Instance
     * @param $clientId
     * @param $secret
     * @throws ePaisaException
     * @internal param array $config
     */
    public function __construct($clientId, $secret)
    {
        (new \Dotenv\Dotenv(__DIR__ . DIRECTORY_SEPARATOR . '../config/'))->load();
        if (empty($_ENV['CLIENT_ID'])) {
            throw new ePaisaException('client id not defined!');
        }
        if (empty($_ENV['CLIENT_SECRET'])) {
            throw new ePaisaException('client secret not defined!');
        }

        $this->clientId = $clientId;
        $this->secret = $secret;
        $this->client = new Request($this);
    }

    /**
     * get client id string
     *
     * @return string Returns the phrase passed in
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * get client secret string
     *
     * @return string Returns the phrase passed in
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * get client object
     *
     * @return string Returns the phrase passed in
     */
    public function getClient()
    {
        return $this->client;
    }
}

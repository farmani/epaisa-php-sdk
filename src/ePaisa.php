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
     * ePaisa client
     *
     * @var \eigitallabs\ePaisa\Request
     */
    protected $client = null;

    /**
     * Create a new Skeleton Instance
     * @param $token
     * @throws ePaisaException
     * @internal param array $config
     */
    public function __construct($token)
    {
        $dotEnv = new \Dotenv\Dotenv(__DIR__ . DIRECTORY_SEPARATOR . '../config/');
        $dotEnv->required(['CLIENT_ID', 'CLIENT_SECRET']);
        $dotEnv->overload();

        $this->client = new Request($this);
    }

    public function createPayment()
    {
        return new Payment($this->client);
    }

    public function createProfile()
    {
        return new Profile($this->client);
    }
}

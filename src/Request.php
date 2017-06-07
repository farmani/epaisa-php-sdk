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
use GuzzleHttp\Client;
use GuzzleHttp\Handler\StreamHandler;
use Monolog\Logger;

class Request
{
    /**
     * ePaisa object
     *
     * @var \eigitallabs\ePaisa\ePaisa
     */
    private $epaisa;
    /**
     * URI of the ePaisa API
     *
     * @var string
     */
    private $apiBaseUri = 'https://halil.epaisa.com';
    /**
     * Guzzle Client object
     *
     * @var \GuzzleHttp\Client
     */
    private $client;
    /**
     * Available actions to send
     *
     * @var array
     */
    private static $actions = [
        'auth',
        'login',
        'register',
        'forgetPassword',
        'logout',
    ];

    /**
     * Initialize
     *
     * @param \eigitallabs\ePaisa\ePaisa $epaisa
     *
     * @throws \eigitallabs\ePaisa\Exception\ePaisaException
     */
    public function __construct(ePaisa $epaisa)
    {
        if (is_object($epaisa)) {
            $this->epaisa = $epaisa;
            $this->client = new Client([
                'base_uri' => $this->apiBaseUri,
                'timeout'  => 2.0,
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
                ]);
        } else {
            throw new ePaisaException('ePaisa pointer is empty!');
        }
    }

    /**
     * Make sure the data isn't empty, else throw an exception
     *
     * @param array $data
     *
     * @throws \eigitallabs\ePaisa\Exception\ePaisaException
     */
    private static function ensureNonEmptyData(array $data)
    {
        if (count($data) === 0) {
            throw new ePaisaException('Data is empty!');
        }
    }


    /**
     * @param $string
     * @return string
     */
    function prepare($string)
    {
        $stringNum = str_split($string, 8);
        $stringNum = 8 - strlen($stringNum[count($stringNum) - 1]);
        for ($i = 0; $i < $stringNum; $i++) {
            $string = $string . chr($stringNum);
        }

        $encrypted = Encrypt::encrypt($string, $_ENV['CLIENT_SECRET'], substr($_ENV['CLIENT_ID'], 0, 8));

        return strtr(base64_encode($encrypted), '+/=', '-_,');
    }

    /**
     * @param $rout
     * @param $verb
     * @param $data
     * @return array|\Psr\Http\Message\StreamInterface
     */
    public function send($rout, $verb, $data)
    {
        $response = $this->client->request(strtoupper($verb), $rout, [
            'form_params' => [
                'clientId'      => $_ENV['CLIENT_ID'],
                'requestParams' => $this->prepare($this->epaisa->token . "####" . json_encode($data)),
            ]
        ]);
        if($response->getStatusCode() == 200) {
            $result = $response->getBody();
            if (isset($result['success']) && $result['success'] == 1) {
                Log::update("Login operation completed successfully!");
                return $result;
            }
        }

        Log::error('Operation failed.');
        return [];
    }
}
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
                    'X-Client-ID' => $client_id,
                    'X-Access-Token' => $access_token,
                ]
                ]);
            $logger = new Logger('client');
            $logger->pushHandler(new StreamHandler('guzzle.log'));

            $logAdapter = new MonologLogAdapter($logger);

            $logPlugin = new LogPlugin($logAdapter, MessageFormatter::DEBUG_FORMAT);

            /** @var $client Client */
            $client = new Client("https://qrng.anu.edu.au");

            $client->addSubscriber($logPlugin);
        } else {
            throw new ePaisaException('ePaisa pointer is empty!');
        }
    }

    /**
     * Make sure the action is valid, else throw an exception
     *
     * @param string $action
     *
     * @throws \eigitallabs\ePaisa\Exception\ePaisaException
     */
    private static function ensureValidAction($action)
    {
        if (!in_array($action, self::$actions, true)) {
            throw new ePaisaException('The action "' . $action . '" doesn\'t exist!');
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
     * @param $email
     * @param $password
     * @return bool
     */
    private function login($email, $password)
    {
        $res = $this->client->request('POST', '/user/login');
        echo $res->getStatusCode();
        echo $res->getHeader('content-type');
        echo $res->getBody();

        $client = new Client();
        $response = $client->createRequest()
            ->setUrl("/user/login")
            ->setMethod('post')
            ->setData([
                'clientId'      => $this->epaisa->getClientId(),
                'requestParams' => $this->prepare(json_encode([
                    'username' => $email,
                    'password' => $password,
                    'sourceId' => $this->epaisa->getSourceId(),
                ])),
            ])
            ->send();

        if ($response->isOk) {
            $response->setFormat(Client::FORMAT_JSON);
            if (isset($response->data['success']) && $response->data['success'] == 1) {
                Log::update("Login operation completed successfully!");
                $this->setAuthKey($response->data['response']['auth_key']);
                return true;
            }
        }

        Log::error('Authentication failed.');
        return false;
    }
}
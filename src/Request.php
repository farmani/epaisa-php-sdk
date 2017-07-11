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

class Request
{
    /**
     * ePaisa object
     *
     * @var \eigitallabs\ePaisa\ePaisa
     */
    private $epaisa;
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
                'base_uri' => $_ENV['API_URL'],
                'timeout'  => 100,
                'headers'  => [
                    'Content-Type' => 'application/json',
                ]
            ]);
            defined('SESSION_ENC_KEY') or define('SESSION_ENC_KEY',
                'def00000c196c56c35c837c8ac30d976e2f1b5008a07cfa583452b59e8ec54120a896e642a21cf');
            $session = new SessionHandler(SESSION_ENC_KEY);
            session_set_save_handler($session, true);
            $session->sessionStart();
        } else {
            throw new ePaisaException('ePaisa pointer is empty!');
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
     * @param $withAuthKey
     * @return array
     */
    public function send($rout, $verb, $data, $withAuthKey = true)
    {
        return (strtoupper($verb) === 'GET') ? $this->sendGet($rout, $data, $withAuthKey) :
            $this->sendPost($rout, $verb, $data, $withAuthKey);
    }

    /**
     * @param $rout
     * @param $data
     * @param bool $withAuthKey
     * @return array
     * @throws ePaisaException
     */
    public function sendGet($rout, $data, $withAuthKey = true)
    {
        if ($withAuthKey) {
            $payload = $this->getAuthKey() . "####" . json_encode($data);
        } else {
            $payload = json_encode($data);
        }
        try {
            $response = $this->client->request('GET', $rout, [
                'query' => [
                    'clientId'      => $_ENV['CLIENT_ID'],
                    'requestParams' => $this->prepare($payload),
                ]
            ]);
            if ($response->getStatusCode() == 200) {
                $result = (string)$response->getBody();
                $resultArray = json_decode($result, true);
                if (!empty($resultArray)) {
                    if (isset($resultArray['success']) && $resultArray['success'] == 1) {
                        Log::debug("Operation completed successfully!");

                        return $resultArray;
                    } else {
                        Log::debug("Operation failed!");

                        return $resultArray;
                    }
                } else {
                    Log::error((string)$response->getBody());
                    throw new ePaisaException((string)$response->getBody());
                }
            }
            Log::error((string)$response->getBody());
            throw new ePaisaException('Sending request failed with ' . $response->getStatusCode() . ' status code.');
        } catch (\Exception $e) {
            Log::error((string)$e->getMessage());
            throw new ePaisaException($e->getMessage());
        }
    }

    /**
     * @param $rout
     * @param $verb
     * @param $data
     * @param bool $withAuthKey
     * @return array
     * @throws ePaisaException
     */
    public function sendPost($rout, $verb, $data, $withAuthKey = true)
    {
        if ($withAuthKey) {
            $payload = $this->getAuthKey() . "####" . json_encode($data);
        } else {
            $payload = json_encode($data);
        }
        try {
            $response = $this->client->request(strtoupper($verb), $rout, [
                'form_params' => [
                    'clientId'      => $_ENV['CLIENT_ID'],
                    'requestParams' => $this->prepare($payload),
                ]
            ]);
            if ($response->getStatusCode() == 200) {
                $result = (string)$response->getBody();
                $resultArray = json_decode($result, true);
                if (!empty($resultArray)) {
                    if (isset($resultArray['success']) && $resultArray['success'] == 1) {
                        Log::debug("Operation completed successfully!");

                        return $resultArray;
                    } else {
                        Log::debug("Operation failed!");

                        return $resultArray;
                    }
                } else {
                    Log::error((string)$response->getBody());
                    throw new ePaisaException((string)$response->getBody());
                }
            }
            Log::error((string)$response->getBody());
            throw new ePaisaException('Sending request failed with ' . $response->getStatusCode() . ' status code.');
        } catch (\Exception $e) {
            Log::error((string)$e->getMessage());
            throw new ePaisaException($e->getMessage());
        }
    }

    /**
     * @param $rout
     * @param $verb
     * @param $data
     * @return array
     * @throws ePaisaException
     */
    public function sendOld($rout, $verb, $data)
    {
        try {
            $response = $this->client->request(strtoupper($verb), $rout, [
                'form_params' => [
                    'clientId'      => $_ENV['CLIENT_ID'],
                    'requestParams' => $this->prepare($this->getAuthKey() . "####" . implode('####', $data)),
                ]
            ]);
            if ($response->getStatusCode() == 200) {
                $result = (string)$response->getBody();
                $resultArray = json_decode($result, true);
                if (!empty($resultArray)) {
                    if (isset($resultArray['success']) && $resultArray['success'] == 1) {
                        Log::debug("Operation completed successfully!");

                        return $resultArray;
                    } else {
                        Log::debug("Operation failed!");

                        return $resultArray;
                    }
                } else {
                    Log::error((string)$response->getBody());
                    throw new ePaisaException((string)$response->getBody());
                }
            }

            Log::error((string)$response->getBody());
            throw new ePaisaException('Sending request failed with ' . $response->getStatusCode() . ' status code.');
        } catch (\Exception $e) {
            Log::error((string)$e->getMessage());
            throw new ePaisaException($e->getMessage());
        }
    }


    /**
     * @return array
     * @throws ePaisaException
     */
    public function login()
    {
        try {
            $response = $this->client->request('POST', '/user/login-with-token', [
                'form_params' => [
                    'clientId'      => $_ENV['CLIENT_ID'],
                    'requestParams' => $this->prepare(json_encode(['token' => $this->epaisa->token])),
                ]
            ]);
            if ($response->getStatusCode() == 200) {
                $result = (string)$response->getBody();
                $resultArray = json_decode($result, true);
                if (!empty($resultArray)) {
                    if (isset($resultArray['success']) && $resultArray['success'] == 1) {
                        Log::debug("Login completed successfully!");
                        $_SESSION['authKey'] = $resultArray['response']['auth_key'];
                        $_SESSION['authKey_created_at'] = $resultArray['response']['auth_key_creationtime'];

                        return $resultArray['response']['auth_key'];
                    }
                } else {
                    Log::error((string)$response->getBody());
                    throw new ePaisaException((string)$response->getBody());
                }
            }
            Log::error((string)$response->getBody());
            throw new ePaisaException('Sending request failed with ' . $response->getStatusCode() . ' status code.');
        } catch (\Exception $e) {
            Log::error((string)$e->getMessage());
            throw new ePaisaException($e->getMessage());
        }
    }

    protected function getAuthKey()
    {
        if (empty($_SESSION['authKey']) || $_SESSION['authKey_created_at'] + 899 < time()) {
            $authKey = $this->login();
        } else {
            $authKey = $_SESSION['authKey'];
        }

        return $authKey;
    }
}
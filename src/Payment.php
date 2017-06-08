<?php
/**
 * Created by PhpStorm.
 * User: Ramin
 * Date: 6/7/2017
 * Time: 5:56 PM
 */

namespace eigitallabs\ePaisa;


class Payment
{
    protected $client;

    public function __construct(Request $client)
    {
        $this->client = $client;
        Log::debug("Payment object initiated.");
    }

    public function initiate($options = [])
    {
        return $this->client->send('/payment/initiate', 'post', $options);
    }

    public function process($options = [])
    {
        return $this->client->send('/payment/process', 'post', $options);
    }

    public function authenticate($options = [])
    {
        return $this->client->send('/payment/authenticate', 'post', $options);
    }

    public function update($options = [])
    {
        return $this->client->send('/payment/update', 'post', $options);
    }

    public function finalize($options = [])
    {
        return $this->client->send('/payment/finalize', 'post', $options);
    }

    public function listMethods($options = [])
    {
        return $this->client->send('/payment/list', 'post', $options);
    }

    public function details($options = [])
    {
        return $this->client->send('/payment/details', 'post', $options);
    }

    public function void($options = [])
    {
        return $this->client->send('/payment/void', 'post', $options);
    }

    public function cancel($options = [])
    {
        return $this->client->send('/payment/cancel', 'post', $options);
    }

    public function receipt($options = [])
    {
        return $this->client->send('/receipt', 'post', $options);
    }
}
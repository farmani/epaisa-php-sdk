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
        Log::update("Payment object initiated.");
    }

    public function initiate()
    {
        /** TODO: initialize payment */
    }

    public function process()
    {
        /** TODO: process payment */
    }

    public function authenticate()
    {
        /** TODO: authenticate payment */
    }

    public function update()
    {
        /** TODO: update payment */
    }

    public function finalize()
    {
        /** TODO: finalize payment */
    }

    public function listMethods()
    {
        /** TODO: list payment */
    }

    public function details()
    {
        /** TODO: details payment */
    }

    public function void()
    {
        /** TODO: void payment */
    }

    public function cancel()
    {
        /** TODO: cancel payment */
    }

    public function receipt()
    {
        /** TODO: receipt payment */
    }
}
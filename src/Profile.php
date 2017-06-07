<?php
/**
 * Created by PhpStorm.
 * User: Ramin
 * Date: 6/7/2017
 * Time: 5:55 PM
 */

namespace eigitallabs\ePaisa;


class Profile
{
    protected $client;

    public function __construct(Request $client)
    {
        $this->client = $client;
        Log::update("Profile object initiated.");
    }

}
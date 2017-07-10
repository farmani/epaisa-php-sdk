<?php
/**
 * Created by PhpStorm.
 * User: Ramin
 * Date: 6/7/2017
 * Time: 5:55 PM
 */

namespace eigitallabs\ePaisa;


/**
 * Class Profile
 * @package eigitallabs\ePaisa
 */
class User
{
    /**
     * @var Request
     */
    protected $client;

    /**
     * Profile constructor.
     * @param Request $client
     */
    public function __construct(Request $client)
    {
        $this->client = $client;
        Log::debug("User object initiated.");
    }

    /**
     * @param array $options
     * @return array
     */
    public function register($options = [])
    {
        return $this->client->send('/user/register', 'post', $options);
    }
}
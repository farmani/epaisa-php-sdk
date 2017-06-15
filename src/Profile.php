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
class Profile
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
        Log::debug("Profile object initiated.");
    }

    /**
     * @param array $options
     * @return array
     */
    public function view($options = [])
    {
        return $this->client->send('/user/profile', 'get', $options);
    }

    /**
     * @param array $options
     * @return array
     */
    public function update($options = [])
    {
        return $this->client->send('/user/profile', 'put', $options);
    }

}
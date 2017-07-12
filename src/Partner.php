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
class Partner
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
        Log::debug("Partner object initiated.");
    }

    /**
     * @param array $options
     * @return array
     */
    public function products($options = [])
    {
        return $this->client->send('/v2.0/partner/merchant/product', 'get', $options);
    }

    /**
     * @param array $options
     * @return array
     */
    public function merchants($options = [])
    {
        return $this->client->send('/v2.0/partner/merchant', 'get', $options);
    }

}
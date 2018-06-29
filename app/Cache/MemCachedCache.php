<?php
/**
 * Created by IntelliJ IDEA.
 * User: HatsOn
 * Date: 6/29/2018
 * Time: 5:00 PM
 */

namespace App\Cache;


class MemCachedCache implements KeyValueCache
{
    private $client = null;
    private $default_ttl = null;

    /***
     * MemCachedCache constructor.
     * @param $host
     * @param $port
     * @param $default_ttl
     */
    public function __construct($host, $port, $default_ttl)
    {
        $this->client = new \Memcache();
        $this->client->connect($host ?: '127.0.0.1', $port ?: 11211);
        $this->default_ttl = $default_ttl ?: 60 * 60 * 5;
    }

    /***
     * @param $key
     * @param $value
     * @param null $ttl
     * @return mixed|void
     */
    public function set($key, $value, $ttl = null)
    {
        $this->client->set($key, $value,false,  $ttl ?: $this->default_ttl);
    }

    /***
     * gets a cache entry with a key
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->client->get($key);
    }
}
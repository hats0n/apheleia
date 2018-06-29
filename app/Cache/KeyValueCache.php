<?php
/**
 * Created by IntelliJ IDEA.
 * User: HatsOn
 * Date: 6/29/2018
 * Time: 4:58 PM
 */

namespace App\Cache;


interface KeyValueCache
{
    /***
     * sets the provided value and key in the cache
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value);


    /***
     * gets a cache entry with a key
     * @param $key
     * @return mixed
     */
    public function get($key);


    public function flush();

}
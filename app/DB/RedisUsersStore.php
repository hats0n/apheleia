<?php
/**
 * Created by IntelliJ IDEA.
 * User: HatsOn
 * Date: 6/29/2018
 * Time: 3:13 PM
 */

namespace App\DB;


use Predis\Client;

class RedisUsersStore implements UsersStore
{

    private $redis_client = null;
    public function __construct($redis_configuration)
    {
        $this->redis_client = new Client([
            'host'=> $redis_configuration['host'] ?: '127.0.0.1',
            'port' => $redis_configuration['port'] ?: 6379
        ]);
    }

    public function addUser($username, $password)
    {
        $this->redis_client->set($username, md5($password));
    }

    public function checkUser($username, $toCheckPassword)
    {
        $persistedPassword = $this->redis_client->get($username);
        return $persistedPassword ? $persistedPassword == md5($toCheckPassword) : false;
    }
}
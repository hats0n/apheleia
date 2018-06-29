<?php
/**
 * Created by IntelliJ IDEA.
 * User: HatsOn
 * Date: 6/29/2018
 * Time: 3:13 PM
 */

namespace App\DB;


interface UsersStore
{
    public function addUser($username, $password);
    public function checkUser($username, $toCheckPassword);
}
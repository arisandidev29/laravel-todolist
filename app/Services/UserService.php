<?php

namespace App\Services;

use PhpParser\Node\Expr\Cast\Object_;

interface UserService
{
    function login(string $user, string $password): bool;
    function register( $data);
}

<?php

declare(strict_types=1);

namespace App\Models;

class User
{
    public int $id;

    public string $login;

    public readonly string $password;

    public bool $isAdmin;

    public static function make($params = []): static
    {
        $params = (array) $params;
        $user = new static();
        $user->id = (int) $params['id'];
        $user->login = $params['login'];
        $user->isAdmin = (bool) ($params['isAdmin'] ?? $params['is_admin']);

        return $user;
    }
}

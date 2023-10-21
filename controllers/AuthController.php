<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App\App;
use App\App\Database\QueryBuilder;
use App\Models\User;

class AuthController
{
    protected string $table;

    protected QueryBuilder $query;

    public function __construct()
    {
        $this->table = 'users';
        $this->query = App::get('DB');
    }

    public function showLoginForm()
    {
        if (!empty($_SESSION['user'])) {
            return redirect('/tasks');
        }

        return view('auth.login');
    }

    public function login()
    {
        $login = trim(strip_tags($_POST['login'] ?? ''));
        $password = trim(strip_tags($_POST['password'] ?? ''));

        $user = $this->query->findByLogin($this->table, $login);

        if (empty($user)) {
            return view('404');
        }
        if (!password_verify($password, $user['password'])) {
            return view('404');
        }

        $_SESSION['user'] = User::make([
            'id' => $user['id'],
            'login' => $user['login'],
            'is_admin' => (bool) $user['is_admin'],
        ]);

        return redirect('tasks');
    }

    public function logout()
    {
        if (!empty($_SESSION['user'])) {
            // session_destroy();
            unset($_SESSION['user']);
        }

        return redirect('tasks');
    }
}

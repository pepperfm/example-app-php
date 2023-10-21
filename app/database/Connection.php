<?php

declare(strict_types=1);

namespace App\App\Database;

use PDO;

class Connection
{
    public static function make(array $config): PDO
    {
        try {
            return new PDO(
                dsn: "{$config['CONNECTION']}:dbname={$config['NAME']};host={$config['HOST']}",
                username: $config['USERNAME'],
                password: $config['PASSWORD']
            );
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}

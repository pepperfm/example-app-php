<?php

declare(strict_types=1);

namespace App\Models;

class Task
{
    public int $id;

    public string $name;

    public string $email;

    public bool $status;

    public string $text;

    public function statusLabel(): string
    {
        return $this->status ? 'Done' : 'New';
    }
}

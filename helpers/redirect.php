<?php

declare(strict_types=1);

function redirect(string $endpoint): void
{
    header("Location: /$endpoint");
}

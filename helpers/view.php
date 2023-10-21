<?php

declare(strict_types=1);

function view(string $viewName, array $context = []): void
{
    extract($context);
    $filePath = str_replace('.', '/', $viewName);

    require "views/$filePath.php";
}

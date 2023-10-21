<?php

declare(strict_types=1);

#[\JetBrains\PhpStorm\NoReturn]
function dd($obj): void
{
    echo '<pre>';
    var_dump($obj);
    echo '</pre>';
    exit();
}

<?php

declare(strict_types=1);

namespace App\App;

class Router
{
    protected array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public static function load(string $file): static
    {
        $router = new static();
        require $file;

        return $router;
    }

    public function get($uri, $controller): void
    {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller): void
    {
        $this->routes['POST'][$uri] = $controller;
    }

    /**
     * @throws \Exception
     */
    public function direct(string $uri, string $method)
    {
        if (array_key_exists($uri, $this->routes[$method])) {
            return $this->callAction(...explode('@', $this->routes[$method][$uri]));
        }

        return view('404');
    }

    /**
     * @throws \Exception
     */
    protected function callAction($controller, $action)
    {
        $controller =  "App\\Controllers\\$controller";
        $controller = new $controller;

        if (!method_exists($controller, $action)) {
            throw new \Exception("$controller does not have $action action");
        }

        return $controller->$action();
    }
}

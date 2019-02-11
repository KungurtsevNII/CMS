<?php

namespace App\App;

use App\Exception\NotFoundException;

class Router
{
    // Массив зарегистрированных маршрутов.
    private $route = [];

    /**
     * Метод регистрации маршрута типа GET:
     * <GET> <uri> <метод, формирующий ответ>
     *
     * @param $uri
     * @param $callback
     * @internal param $route
     * @internal param $url
     * @internal param $callback
     */
    public function get($uri, $callback)
    {
        // Приводим маршрут к единообразию.
        $uri = '/' . trim($uri, '/');
        // Регистрируем маршрут.
        $this->route[] = new Route("GET", $uri, $callback);
    }

    /**
     *  Метод регистрации маршрута типа POST:
     * <POST> <uri> <метод, формирующий ответ>
     *
     * @param $uri
     * @param $callback
     */
    public function post($uri, $callback)
    {
        // Приводим маршрут к единообразию.
        $uri = '/' . trim($uri, '/');
        // Регистрируем маршрут.
        $this->route[] = new Route("POST", $uri, $callback);
    }

    /**
     * Подбор маршрута для запроса пользователя.
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function dispatch()
    {
        $requestUri = '/' . trim($_SERVER['REQUEST_URI'], '/');
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        foreach ($this->route as $route) {
            if ($route->match($requestMethod, $requestUri)) {
                return $route->run($requestUri);
            }
        }
        throw new NotFoundException();
    }
}

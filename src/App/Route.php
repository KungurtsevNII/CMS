<?php

namespace App\App;

class Route
{
    // http запрос, для которого подходит маршрут get или post.
    private $method;

    // URI маршрута.
    private $path;

    // callback - маршрута.
    private $callback;

    /**
     * Route конструктор.
     *
     * @param $method
     * @param $path
     * @param $callback
     */
    public function __construct($method, $path, $callback)
    {
        $this->method = $method;
        $this->path = $path;
        $this->callback = $this->prepareCallback($callback);
    }


    /**
     * Преобразует callback к исполняемой callback функции.
     *
     * @param $callback
     * @return mixed
     */
    private function prepareCallback($callback)
    {
        // Если передана callback функция,
        // то возвращаем ее.
        if (is_callable($callback)) {
            return $callback;
        }

        // Иначе вызываем действие у FrontController.
        // Разбиваем строку на контроллер и действие.
        list($controller, $action) = explode('@', $callback);

        // Возвращаем функцию, в которой проиходит вызов действия,
        // дабы стэк вызовов был не так рано.
        return function (...$params) use ($controller, $action) {
            $controller = new $controller;
            return call_user_func_array([$controller, $action], func_get_args());
        };
    }

    /**
     * Возвращает URI маршрута.
     *
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Подходит ли маршрут к запросу из параметров.
     *
     * @param $method
     * @param $uri
     * @return bool
     */
    public function match($method, $uri) : bool
    {
        // Если метод запроса и запрошенный uri совпадают.
        if ($method == $this->method && preg_match('/^' . str_replace(['*', '/'], ['\w+', '\/'], $this->getPath()) . '$/', $uri)) {
            return true;
        }
        return false;
    }

    /**
     * Запускает и возвращает результат работы своей callback-функции.
     * Он получает параметры из текущего url,
     * и передает их в callback функцию.
     *
     * @param $uri
     * @return mixed
     */
    public function run($uri)
    {
        // Массив параметров.
        $arrayParameters = [];
        // Зарег. маршрут в виде массива.
        $arrayPattern = explode('/', trim($this->getPath(), '/'));
        // URI в ввиде массива.
        $arrayUri = explode('/', trim($uri, '/'));

        // Находим ключ (*) и записываем параметр из
        // массива URI в массив параметров.
        foreach ($arrayPattern as $key => $value) {
            if ($value == '*') {
                $arrayParameters[] = $arrayUri[$key];
            }
        }

        // Если параметры не переданы, то вызываем метод/функцию.
        if (empty($arrayParameters)) {
            return call_user_func($this->callback);
        }

        // Вызываем callback функцию с параметрами из $uri.
        return call_user_func_array($this->callback, $arrayParameters);

    }
}

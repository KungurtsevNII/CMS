<?php

namespace App\App;

use App\View\View;

class Controller
{
    /**
     * Действие
     *
     * @return View
     */
    public function index()
    {
        return new View('index', ['title' => 'Index Page']);
    }

    /**
     * Действие
     *
     * @return View
     */
    public function about()
    {
        return new View('about', ['title' => 'About page']);
    }

    /**
     * Действие, которое принимает параметр из uri.
     *
     * @param $type
     * @param $number
     * @return View
     */
    public function products($type, $number)
    {
        return new View('products', [
            'title' => 'Товар по скидке номер',
            'number' => $number,
            'type' => $type
        ]);
    }
}
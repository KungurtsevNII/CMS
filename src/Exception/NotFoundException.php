<?php

namespace App\Exception;

use App\View\Renderable;

class NotFoundException extends HttpException implements Renderable
{

    public function render()
    {
        require_once VIEW_DIR . 'error.php';
    }
}
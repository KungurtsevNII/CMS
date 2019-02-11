<?php

namespace App\App;

use App\View\Renderable;
use ActiveRecord\Config as ActiveveConfig;

class Application
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->initialize();
    }

    public function run()
    {
        try {
            $objFromCallBack = $this->router->dispatch();
            if ($objFromCallBack instanceof Renderable) {
                $objFromCallBack->render();
            } else {
                echo $objFromCallBack;
            }
        } catch (\Exception $e) {
            $this->renderException($e);
        }
    }

    private function initialize()
    {
        $db = Config::getInstance()->get('db');
        ActiveveConfig::initialize(function($cfg) use ($db)
        {
            $cfg->set_model_directory(APP_DIR . 'src' . DIRECTORY_SEPARATOR . 'Model');
            $cfg->set_connections(
                array(
                    'development' => 'mysql://' . $db['user'] . ':' . $db['password'] . '@' . $db['host'] . '/' . $db['db'],
                )
            );
        });
    }

    private function renderException(\Exception $exception)
    {
        if ($exception instanceof Renderable) {
            $exception->render();
        }
        return $exception->getMessage();
    }
}
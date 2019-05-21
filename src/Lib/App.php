<?php
/**
 * Ascetic-CMS App
 * Продумать логику - создание объекта App , прописывание  маршрутоа, обработка теукущего  и рендер после запуска App->run(); 
 */

namespace AsceticCMS\Lib;

class App
{
    const VERSION = '0.1.1';
    public $callbackArray = [];
    public function showInfo()
    {
        return self::VERSION;
    }

    public function sayHello()
    {
        return "Hello!";
    }

    public function get($str, callable $callback)
    {
        if (!is_string($str)) {
            throw new \Exception('not valid param $str in App->get($str, $callback)');
        }
        if (Router::get($str, $callback)) {
            array_push($this->callbackArray, $callback);
        }
    }

    public function put($str, $callback)
    {
        if (Router::put($str, $callback)) {
            array_push($this->callbackArray, $callback);
        }
    }

    public function run()
    {
        try {
            if (count($this->callbackArray) === 0) {
                $resp = new Response('404 Not Found!', 'Error! This page not found! Please check web-address!');
                $resp->send();
                return false;
            } else if (count($this->callbackArray) === 1) {
                $callFunc = array_pop($this->callbackArray);
                call_user_func($callFunc);
                return true;
            } else {
                $resp = new Response('500 Server Error!', 'Error!!! Please message to system administrator! ');
                $resp->send();
                return false;
            }
        } catch (Exception $e) {
            ErrorsHandler::saveLog($e);
        }
    }
}

<?php


namespace Core;

use App\Auth;
use App\Flash;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class Controller
{
    protected $route_params = [];

    public function __call($name, $arguments)
    {
        $method = $name . 'Action';
        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $arguments);
                $this->after();
            }
        } else {
            throw new \Exception("Method '$method' not found in controller " . get_class($this), 404);
        }
    }

    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    protected function before()
    {
    }

    protected function after()
    {
    }

    public function redirect($url): void
    {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $url, true, 303);
        exit;
    }

    public function requireLogin(): void
    {
        if (!Auth::getUser()) {
            // json response
            $request = Request::createFromGlobals();
            $response = new JsonResponse(['message' => 'unauthorized user please login first'],401);
            $response->prepare($request);
            $response->send();
            exit;

            // html response
//            Auth::rememberRequestedPage();
//            Flash::addMessage('Please login to access that page');
//            $this->redirect('/login');
        }
    }
}
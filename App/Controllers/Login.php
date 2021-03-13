<?php


namespace App\Controllers;

use App\Models\Service\LoginService;
use \Core\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Login extends \Core\Controller
{
    public function newAction(): void
    {
        View::renderTemplate('Login/new.html');
    }

    public function createAction(): void
    {
        if (LoginService::createActionController()) {
            // json response
            $request = Request::createFromGlobals();
            $response = new JsonResponse(['message' => "login Successfully"], 200);
            $response->prepare($request);
            $response->send();


            // html response
//            $this->redirect(Auth::getReturnToPage());
        } else {
            // json response
            $request = Request::createFromGlobals();
            $response = new JsonResponse(['error' => "login unsuccessful please try again"], 404);
            $response->prepare($request);
            $response->send();

            // html response
//            View::renderTemplate('Login/new.html', [
//                'email' => $_POST['email'],
//            ]);
        }
    }

    public function destroyAction(): void
    {
        LoginService::destroyActionController();
        // json response
        $request = Request::createFromGlobals();
        $response = new JsonResponse(['error' => "logout successfully"], 200);
        $response->prepare($request);
        $response->send();

        // html response
//        $this->redirect('/login/show-logout-message');
    }

    public function showLogoutMessageAction(): void
    {
        LoginService::showLogoutMessageActionController();
        $this->redirect('/');
    }
}
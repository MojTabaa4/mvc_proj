<?php


namespace App\Controllers;

use App\Models\Service\SignupService;
use Core\Controller;
use \Core\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Signup extends Controller
{
    public function newAction(): void
    {
        View::renderTemplate('Signup/index.html');
    }

    public function createAction(): void
    {
        $user = SignupService::createActionController();
        if (empty($user->getErrors())) {
            // json response
            $request = Request::createFromGlobals();
            $response = new JsonResponse(['message' => 'sign up successfully'], 201);
            $response->prepare($request);
            $response->send();

            // html response
//            $this->redirect('/signup/success');
        } else {
            // json response
            $request = Request::createFromGlobals();
            $response = new JsonResponse(['errors' => $user->getErrors()], 400);
            $response->prepare($request);
            $response->send();

            // html response
//            View::renderTemplate('Signup/index.html', [
//                'user' => $user,
//            ]);
        }
    }

    public function editAction(): void
    {
        $user = SignupService::editActionController();
        if (empty($user->getErrors())) {
            // json response
            $request = Request::createFromGlobals();
            $response = new JsonResponse(['message' => 'successfully edited'], 201);
            $response->prepare($request);
            $response->send();

            // html response
            // redirect to
//            $this->redirect('//success');
        } else {
            // json response
            $request = Request::createFromGlobals();
            $response = new JsonResponse(['errors' => $user->getErrors()], 400);
            $response->prepare($request);
            $response->send();

            // html response
//            View::renderTemplate('Signup/index.html', [
//                'user' => $user,
//            ]);
        }
    }

    public function successAction(): void
    {
        View::renderTemplate('Signup/success.html');
    }
}
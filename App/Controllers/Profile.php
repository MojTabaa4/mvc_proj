<?php


namespace App\Controllers;

use \App\Models\Entities\User;
use App\Models\Service\ProfileService;
use \Core\View;
use \App\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Profile extends Authenticated
{
    public function showAction(): void
    {
        $user = Auth::getUser();

        // json response
        $request = Request::createFromGlobals();
        $response = new JsonResponse([
            'name' => $user->getName(),
            'email' => $user->getEmail()
        ], 200);
        $response->prepare($request);
        $response->send();

        // html response
//        View::renderTemplate('Profile/show.html', [
//            'user' => $user,
//        ]);
    }

    public function newEditAction(): void
    {
        View::renderTemplate('Profile/edit.html', [
            'user' => Auth::getUser()
        ]);
    }

    public function editAction(): void
    {
        $user = ProfileService::editActionController();
        if (empty($user->getErrors())) {
            // json response
            $request = Request::createFromGlobals();
            $response = new JsonResponse(['message' => 'successfully edited'],201);
            $response->prepare($request);
            $response->send();

            // html response
            // redirect to
//            $this->redirect('/profile');
        } else {
            // json response
            $request = Request::createFromGlobals();
            $response = new JsonResponse(['errors' => $user->getErrors()],400);
            $response->prepare($request);
            $response->send();

            // html response
//            View::renderTemplate('Profile/edit.html', [
//                'user' => $user
//            ]);
        }
    }

    public function successEditAction(): void
    {
        View::renderTemplate('Profile/show.html', [
            'user' => Auth::getUser()
        ]);
    }
}
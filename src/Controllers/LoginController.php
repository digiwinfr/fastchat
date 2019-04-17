<?php
namespace Digiwin\Fastchat\Controllers;

use Digiwin\Fastchat\Models\User;
use Digiwin\Fastchat\Repositories\UserRepository;
use Digiwin\Fastchat\Services\SecurityService;

class LoginController extends Controller
{

    private $repository;


    public function __construct()
    {
        $this->repository = new UserRepository();
    }


    public function form()
    {
        $this->render('login/form');
    }


    public function login()
    {
        $email = trim($_POST['email']);
        $nickname = trim($_POST['nickname']);
        if ($email != '' && $nickname != '') {
            $user = new User();
            $user->email = $email;
            $user->nickname = $nickname;
            $user = $this->repository->save($user);
            SecurityService::startSession($user);
            $this->redirect('/');
        } else {
            $this->redirect('/login');
        }
    }


    public function logout()
    {
        $user = SecurityService::getUser();
        $this->repository->disconnect($user->id);
        SecurityService::destroySession();
        $this->redirect('/login');
    }
}
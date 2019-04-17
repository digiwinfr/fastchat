<?php
namespace Digiwin\Fastchat\Controllers;

use Digiwin\Fastchat\Repositories\UserRepository;

class UserController extends Controller
{
    private $repository;


    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function all()
    {
        $users = $this->repository->all();
        self::renderJson($users);
    }
}
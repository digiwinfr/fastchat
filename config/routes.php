<?php
use \Digiwin\Fastchat\Controllers\ChatController;
use \Digiwin\Fastchat\Controllers\MessageController;
use \Digiwin\Fastchat\Controllers\UserController;
use \Digiwin\Fastchat\Controllers\LoginController;
use \Digiwin\Fastchat\Services\SecurityService;

$router = new \Bramus\Router\Router();


$chatController = new ChatController();
$messageController = new MessageController();
$userController = new UserController();
$loginController = new LoginController();

$router->get('', function () use ($chatController) {
    $chatController->display();
});

$router->get('/messages', function () use ($messageController) {
    $messageController->latest();
});

$router->post('/messages', function () use ($messageController) {
    $messageController->add();
});

$router->get('/users', function () use ($userController) {
    $userController->all();
});

$router->get('/login', function () use ($loginController) {
    $loginController->form();
});

$router->post('/login', function () use ($loginController) {
    $loginController->login();
});

$router->get('/logout', function () use ($loginController) {
    $loginController->logout();
});

$router->before('GET|POST', '/((?!login|logout).)*', function () {
    if (!SecurityService::hasSession()) {
        header('Location: /login');
        exit();
    }
});

$router->run();
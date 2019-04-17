<?php
use \Digiwin\Fastchat\Controllers\ChatController;
use \Digiwin\Fastchat\Controllers\MessageController;
use \Digiwin\Fastchat\Controllers\UserController;

$router = new \Bramus\Router\Router();

$chatController = new ChatController();
$messageController = new MessageController();
$userController = new UserController();

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

$router->run();
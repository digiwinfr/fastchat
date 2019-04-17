<?php
use \Digiwin\Fastchat\Controllers\ChatController;
use \Digiwin\Fastchat\Controllers\MessageController;

$router = new \Bramus\Router\Router();

$chatController = new ChatController();
$messageController = new MessageController();

$router->get('', function () use ($chatController) {
    $chatController->display();
});

$router->get('/messages', function () use ($messageController) {
    $messageController->all();
});

$router->run();
<?php
use \Digiwin\Fastchat\Controllers\ChatController;

$router = new \Bramus\Router\Router();

$chat = new ChatController();

$router->get('', function () use ($chat) {
    $chat->display();
});

$router->run();
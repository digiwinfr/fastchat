<?php
use \Digiwin\Fastchat\Controllers\ChatController;

$router = new \Bramus\Router\Router();

$router->get('', function () {
    ChatController::display();
});

$router->run();
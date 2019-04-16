<?php
namespace Digiwin\Fastchat\Controllers;

use Digiwin\Fastchat\Repositories\MessageRepository;

class MessageController extends Controller
{
    public function all()
    {
        $repository = new MessageRepository();
        $messages = $repository->all();
        self::renderJson($messages);
    }
}
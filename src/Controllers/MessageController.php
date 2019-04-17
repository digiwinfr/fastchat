<?php
namespace Digiwin\Fastchat\Controllers;

use Digiwin\Fastchat\Models\Message;
use Digiwin\Fastchat\Models\User;
use Digiwin\Fastchat\Repositories\MessageRepository;

class MessageController extends Controller
{
    private $repository;


    public function __construct()
    {
        $this->repository = new MessageRepository();
    }

    public function latest()
    {
        $messages = $this->repository->findtLatest();
        self::renderJson($messages);
    }

    public function add()
    {
        $message = new Message();
        $user = new User();
        $user->id = 1;
        $message->author = $user;
        $now = new \DateTime();
        $message->date = $now->format('Y-m-d H:i:s');
        $message->content = $_POST['content'];
        $this->repository->save($message);
        self::renderJson($message);
    }
}
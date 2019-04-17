<?php
namespace Digiwin\Fastchat\Controllers;

use Digiwin\Fastchat\Models\Message;
use Digiwin\Fastchat\Repositories\MessageRepository;
use Digiwin\Fastchat\Services\SecurityService;

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
        $content = $_POST['content'];
        if(trim($content) != '') {
            $message = new Message();
            $message->author = SecurityService::getUser();
            $now = new \DateTime();
            $message->date = $now->format('Y-m-d H:i:s');
            $message->content = $content;
            $this->repository->save($message);
            self::renderJson($message);
        }
    }
}
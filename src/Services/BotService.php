<?php
namespace Digiwin\Fastchat\Services;

use Digiwin\Fastchat\Models\Message;
use Digiwin\Fastchat\Models\User;
use Digiwin\Fastchat\Repositories\MessageRepository;
use Digiwin\Fastchat\Repositories\UserRepository;

class BotService
{
    private $messageRepository;
    private $userRepository;
    private $bot;


    public function __construct()
    {
        $this->messageRepository = new MessageRepository();
        $this->userRepository = new UserRepository();
        $this->bot = $this->userRepository->findBotByName('bot');
    }

    public function sayWelcomeTo(User $user)
    {
        $message = new Message();
        $message->author = $this->bot;
        $now = new \DateTime();
        $message->date = $now->format('Y-m-d H:i:s');
        $message->content = ':tada: Bienvenue ' . $user->nickname . ' !';

        $this->messageRepository->save($message);
    }

    public function sayGoodByTo(User $user)
    {
        $message = new Message();
        $message->author = $this->bot;
        $now = new \DateTime();
        $message->date = $now->format('Y-m-d H:i:s');
        $message->content = 'A bientôt ' . $user->nickname . ' !';

        $this->messageRepository->save($message);
    }
}
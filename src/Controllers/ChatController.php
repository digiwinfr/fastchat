<?php
namespace Digiwin\Fastchat\Controllers;

class ChatController extends Controller
{
    public function display()
    {
        $this->render('chat/display');
    }
}
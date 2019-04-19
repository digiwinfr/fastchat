<?php
namespace Digiwin\Fastchat\Models;

class Message implements Model
{
    public $id;

    public $content;

    public $date;

    public $author;

    public function hydrate($array)
    {
        $this->id = $array['id'];
        $this->content = $array['content'];
        $this->date = $array['date'];
        $author = new User();
        $author->hydrate([
            'id' => $array['author_id'],
            'nickname' => $array['nickname'],
            'email' => $array['email'],
            'bot' => $array['bot'],
            'connected' => $array['connected']
        ]);
        $this->author = $author;
    }
}
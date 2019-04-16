<?php
namespace Digiwin\Fastchat\Models;

class Message implements Model
{
    public $id;

    public $content;

    public $date;

    public $author;

    public function fromArray($array)
    {
        $this->id = $array['id'];
        $this->content = $array['content'];
        $this->date = $array['date'];
        $author = new User();
        $author->fromArray([
            'id' => $array['author_id'],
            'nickname' => $array['nickname'],
            'email' => $array['email']
        ]);
        $this->author = $author;
    }
}
<?php
namespace Digiwin\Fastchat\Models;

class User implements Model
{
    public $id;

    public $nickname;

    public $email;

    public function fromArray($array)
    {
        $this->id = $array['id'];
        $this->nickname = $array['nickname'];
        $this->email = $array['email'];
    }
}
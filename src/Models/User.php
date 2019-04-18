<?php
namespace Digiwin\Fastchat\Models;

class User implements Model
{
    public $id;

    public $nickname;

    public $email;

    public $connected;

    public function hydrate($array)
    {
        $this->id = $array['id'];
        $this->nickname = $array['nickname'];
        $this->email = $array['email'];
        $this->connected = $array['connected'] == 1 ? true : false;
    }
}
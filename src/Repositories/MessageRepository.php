<?php
namespace Digiwin\Fastchat\Repositories;

use Digiwin\Fastchat\Models\Message;

class MessageRepository extends Repository
{
    public function all()
    {
        $statement = $this->db->query("SELECT * FROM message LEFT JOIN user ON message.author_id = user.id");
        $all = [];
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $message = new Message();
            $message->fromArray($row);
            $all[] = $message;
        }
        return $all;
    }
}
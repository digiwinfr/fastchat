<?php
namespace Digiwin\Fastchat\Repositories;

use Digiwin\Fastchat\Models\Message;

class MessageRepository extends Repository
{
    public function findtLatest()
    {
        $statement = $this->db->query('SELECT message.*, user.nickname, user.email, user.bot, user.connected FROM message LEFT JOIN user ON message.author_id = user.id ORDER BY message.id DESC LIMIT 0,100');
        $messages = [];
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $message = new Message();
            $message->hydrate($row);
            $messages[] = $message;
        }
        return array_reverse($messages);
    }

    public function findFrom($id)
    {
        $statement = $this->db->query('SELECT message.*, user.nickname, user.email, user.bot, user.connected FROM message LEFT JOIN user ON message.author_id = user.id WHERE message.id > ' . $id . ' ORDER BY message.id ASC LIMIT 0,10');
        $messages = [];
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $message = new Message();
            $message->hydrate($row);
            $messages[] = $message;
        }
        return $messages;
    }

    public function save(Message $message)
    {
        $this->db->exec('INSERT INTO message (content, date, author_id) VALUES (' . $this->sanitize($message->content) . ',\'' . $message->date . '\',' . $message->author->id . ')');
    }
}
<?php
namespace Digiwin\Fastchat\Repositories;

use Digiwin\Fastchat\Models\Message;

class MessageRepository extends Repository
{
    public function findtLatest()
    {
        $statement = $this->db->query('SELECT * FROM message LEFT JOIN user ON message.author_id = user.id ORDER BY message.id DESC LIMIT 0,100');
        $all = [];
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $message = new Message();
            $message->fromArray($row);
            $all[] = $message;
        }

        return array_reverse($all);
    }

    public function save(Message $message)
    {
        $this->db->exec('INSERT INTO message (content, date, author_id) VALUES (' . $this->sanitize($message->content) . ',\'' . $message->date . '\',' . $message->author->id . ')');
    }

    protected function sanitize($string)
    {
        return $this->db->quote(stripslashes($string));
    }
}
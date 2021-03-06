<?php
namespace Digiwin\Fastchat\Repositories;

use Digiwin\Fastchat\Models\User;

class UserRepository extends Repository
{
    public function allHumans()
    {
        $statement = $this->db->query('SELECT * FROM user WHERE bot=0 ORDER BY nickname');
        $users = [];
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $user = new User();
            $user->hydrate($row);
            $users[] = $user;
        }

        return $users;
    }

    public function save(User $user)
    {
        $statement = $this->db->query('SELECT COUNT(id) FROM user WHERE email=' . $this->sanitize($user->email));
        $count = (int)$statement->fetchColumn();
        if ($count == 0) {
            $this->db->exec('INSERT INTO user (email, nickname) VALUES (' . $this->sanitize($user->email) . ',' . $this->sanitize($user->nickname) . ')');
        } else {
            $this->db->exec('UPDATE user SET nickname = ' . $this->sanitize($user->nickname) . ', connected = 1 WHERE email=' . $this->sanitize($user->email));
        }
        return $this->findByEmail($user->email);
    }

    public function findByEmail($email)
    {
        $statement = $this->db->query('SELECT * FROM user WHERE email=' . $this->sanitize($email));
        $user = new User();
        $user->hydrate($statement->fetch(\PDO::FETCH_ASSOC));
        return $user;
    }

    public function disconnect($id)
    {
        $this->db->exec('UPDATE user SET connected = 0 WHERE id=' . $id);
    }

    public function findBotByName($name)
    {
        $statement = $this->db->query('SELECT * FROM user WHERE bot=1 AND nickname=' . $this->sanitize($name));
        $user = new User();
        $user->hydrate($statement->fetch(\PDO::FETCH_ASSOC));
        return $user;
    }
}
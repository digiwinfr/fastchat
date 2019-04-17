<?php
namespace Digiwin\Fastchat\Repositories;

use Digiwin\Fastchat\Models\User;

class UserRepository extends Repository
{
    public function all()
    {
        $statement = $this->db->query('SELECT * FROM user ORDER BY nickname');
        $users = [];
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $user = new User();
            $user->hydrate($row);
            $users[] = $user;
        }

        return $users;
    }
}
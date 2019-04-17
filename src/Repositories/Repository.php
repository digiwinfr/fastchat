<?php
namespace Digiwin\Fastchat\Repositories;

abstract class Repository
{
    protected $db;

    public function __construct()
    {
        $this->db = new \PDO('mysql:host=mysql;dbname=' . DATABASE_NAME . ';charset=utf8', DATABASE_USER, DATABASE_PASSWORD);
    }
}
<?php
namespace Digiwin\Fastchat\Repositories;

abstract class Repository
{
    protected $db;

    public function __construct()
    {
        $this->db = new \PDO('mysql:host=mysql;dbname=fastchat;charset=utf8', 'fastchat', 'fastchat');
    }
}
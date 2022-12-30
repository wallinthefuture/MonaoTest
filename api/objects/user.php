<?php

class User
{
    private $db;

    public $id;
    public $login;
    public $password;
    public $confirm_password;
    public $email;
    public $name;

    public function __construct($db)
    {
        $this->db = $db;
    }

    function create()
    {

        $this->login = htmlspecialchars(strip_tags($this->login));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->confirm_password = htmlspecialchars(strip_tags($this->confirm_password));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->name = htmlspecialchars(strip_tags($this->name));

        $this->db[$this->id]["login"] = $this->login;
        $this->db[$this->id]["password"] = $this->password;
        $this->db[$this->id]["confirm_password"] = $this->confirm_password;
        $this->db[$this->id]["email"] = $this->email;
        $this->db[$this->id]["name"] = $this->name;

        file_put_contents('./config/database.json', json_encode($this->db, JSON_FORCE_OBJECT));
        return true;

    }

}

<?php

class User
{
    private $db;


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
        $this->db["users"][] = array("login" => $this->login, "password" => md5($this->password. "Sault"), "confirm_password" => md5($this->confirm_password. "Sault"), "email" => $this->email, "name" => $this->name);

        file_put_contents('./config/database.json', json_encode($this->db, JSON_FORCE_OBJECT));
        return true;

    }

    function checkEmailAndLogin()
    {

        foreach ($this->db as $users => $item) {
            foreach ($item as $key => $value) {
                if ($value["login"] == $this->login || $value["email"] == $this->email) {
                    return true;
                }
            }
        }
        return false;
    }

}

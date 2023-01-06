<?php

class User
{
    private $db;


    public $login;
    public $password;
    public $confirm_password;
    public $sault;
    public $email;
    public $name;
    public $cookie = "";

    public function __construct($db)
    {
        $this->db = $db;

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

    function checkLoginAndPassword()
    {

        foreach ($this->db as $users => $user) {
            foreach ($user as $key => $value) {

                echo json_encode(md5($this->password . $value["Sault"]));
                echo json_encode($value["password"]);
                echo json_encode($value["Sault"]);
                if ($value["login"] == $this->login && $value["password"] == md5($this->password . $value["Sault"])) {
                    return false;


                }
            }
        }
        return true;
    }


    function findUser()
    {
        foreach ($this->db as $users => $item) {
            foreach ($item as $key => $value) {
                if ($value["login"] == $this->login && $value["cookie"] == $this->cookie) {
                    return true;
                }
            }
        }
        return false;
    }

    function getNameUser()
    {
        foreach ($this->db as $users => $item) {
            foreach ($item as $key => $value) {
                if ($value["login"] == $this->login) {
                    return $value["name"];
                }
            }
        }
        return false;
    }
}

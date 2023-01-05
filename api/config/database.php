<?php

class Database
{

    public $db;

    public function __construct()
    {
        if (file_exists('./config/database.json')) {

            $this->db = json_decode(file_get_contents('./config/database.json'), true);
            return $this->db;
        } else {
            echo "Ошибка подключения к базе данных";
        }
    }

    function createUser($login, $password, $confirm_password, $email, $name, $cookie)
    {
        $this->db["users"][] = array("login" => $login, "password" => md5($password . "Sault"), "confirm_password" => md5($confirm_password . "Sault"), "email" => $email, "name" => $name, "cookie" => "");
        file_put_contents('./config/database.json', json_encode($this->db, JSON_FORCE_OBJECT));
    }

    function updateCookie($cookie, $login)
    {

        foreach ($this->db as $users => $item) {

            foreach ($item as $key => $value) {

                if ($value["login"] == $login) {

                    $this->db[$users][$key]["cookie"] = $cookie;

                    file_put_contents('./config/database.json', json_encode($this->db, JSON_FORCE_OBJECT));
                }
            }
        }
    }
}

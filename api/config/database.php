<?php

class Database
{

    private $db;

    public function __construct()
    {
        if (file_exists('./config/database.json')) {
            $this->db = json_decode(file_get_contents('./config/database.json'), true);
        } else {
            echo "Ошибка подключения к базе данных";
        }
    }

    function getUsers()
    {
        return json_decode(file_get_contents('./config/database.json'), true);
    }

    function createUser($login, $password, $confirm_password, $sault, $email, $name, $cookie)
    {
        try {
            $this->db["users"][] = array("login" => $login, "password" => md5($password . $sault), "confirm_password" => md5($confirm_password . $sault), "Sault" => $sault, "email" => $email, "name" => $name, "cookie" => "");
            file_put_contents('./config/database.json', json_encode($this->db, JSON_FORCE_OBJECT));
        } catch (Throwable $ex) {
            return false;
        }
        return true;
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
    function deleteUser($id){

        if($this->db["users"][$id]){
            unset($this->db["users"][$id]);
            file_put_contents('./config/database.json', json_encode($this->db, JSON_FORCE_OBJECT));
            return true;
        }else{
            return false;
        }




    }
}

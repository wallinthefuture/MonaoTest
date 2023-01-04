<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
session_start();
include_once "./objects/user.php";

$jsonArray = [];
if (file_exists('./config/database.json')) {
    $json = file_get_contents('./config/database.json');
    $jsonArray = json_decode($json, true);
}

$user = new User($jsonArray);

if (empty($_SESSION['auth']) || $_SESSION['auth'] == false) {

    if (!empty($_COOKIE['login']) and !empty($_COOKIE['key'])) {

        $user->login = $_COOKIE['login'];
        $user->cookie = $_COOKIE['key'];

        if ($user->findUser()) {
            session_start();
            $_SESSION['auth'] = true;
            $_SESSION['login'] = $user->login;

        }
        http_response_code(201);
    } else {
        http_response_code(400);
    }

}else{

    http_response_code(201);
}
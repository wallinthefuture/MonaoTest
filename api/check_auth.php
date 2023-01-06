<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
session_start();
include_once "./objects/user.php";
include_once "./config/database.php";
$db = new Database();
$user = new User($db->getUsers());

if (empty($_SESSION['auth']) || $_SESSION['auth'] == false) {

    if (!empty($_COOKIE['login']) and !empty($_COOKIE['key'])) {

        $user->login = $_COOKIE['login'];
        $user->cookie = $_COOKIE['key'];

        if ($user->findUser()) {

            $_SESSION['auth'] = true;
            $_SESSION['login'] = $user->login;

        }
        http_response_code(201);
    } else {
        http_response_code(400);
    }

} else {
    $user->login = $_SESSION['login'];

    http_response_code(201);
    echo json_encode($user->getNameUser());
}
<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "./config/database.php";
include_once "./objects/user.php";
include_once "generate_sault.php";


$db = new Database();
$user = new User($db->getUsers());

$data = json_decode(file_get_contents("php://input"));


if (
    !empty($data->login) &&
    !empty($data->psw) &&
    !empty($data->psw_repeat) &&
    !empty($data->email) &&
    !empty($data->name)

) {
    // устанавливаем значения свойств пользователя
    $user->login = htmlspecialchars(strip_tags($data->login));
    $user->password = htmlspecialchars(strip_tags($data->psw));
    $user->confirm_password =htmlspecialchars(strip_tags($data->psw_repeat));
    $user->email = htmlspecialchars(strip_tags($data->email));
    $user->name = htmlspecialchars(strip_tags($data->name));
    $user->sault = generateSalt();
  
    if ($user->password!= $user->confirm_password){
        http_response_code(400);
        echo json_encode(array("message" => "Пароль не совпадает с подтверждением пароля"), JSON_UNESCAPED_UNICODE);
    } elseif ($user->checkEmailAndLogin()) {
        http_response_code(400);
        echo json_encode(array("message" => "Пользователь с таким логином и почтой есть."), JSON_UNESCAPED_UNICODE);
    } else {
        if ($db->createUser($user->login,$user->password,$user->confirm_password,$user->sault,$user->email, $user->name,$user->cookie)) {
            // установим код ответа - 201 создано
            http_response_code(201);

        } else {

            http_response_code(503);
            echo json_encode(array("message" => "Невозможно создать пользователя."), JSON_UNESCAPED_UNICODE);
        }
    }
} else {

    http_response_code(400);


    echo json_encode(array("message" => "Невозможно создать пользователя. Данные неполные."), JSON_UNESCAPED_UNICODE);
}


<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once "./objects/user.php";

$jsonArray = [];

//Если файл существует - получаем его содержимое
if (file_exists('./config/database.json')) {
    $json = file_get_contents('./config/database.json');
    $jsonArray = json_decode($json, true);
}

$user = new User($jsonArray);

$data = json_decode(file_get_contents("php://input"));
json_encode($data);

if (
    !empty($data->login) &&
    !empty($data->psw) &&
    !empty($data->psw_repeat) &&
    !empty($data->email) &&
    !empty($data->name)

) {


    // устанавливаем значения свойств товара
    $user->login = $data->login;
    $user->password = $data->psw;
    $user->confirm_password = $data->psw_repeat;
    $user->email = $data->email;
    $user->name = $data->name;

    if ($user->checkEmailAndLogin()){
        http_response_code(400);
        echo json_encode(array("message" => "Пользователь с таким логином и почтой есть."), JSON_UNESCAPED_UNICODE);
    }else{
        if ($user->create()) {
            // установим код ответа - 201 создано
            http_response_code(201);

            // сообщим пользователю
            echo json_encode(array("message" => "Комикс был создан."), JSON_UNESCAPED_UNICODE);
        } else {

            http_response_code(503);


            echo json_encode(array("message" => "Невозможно создать комикс."), JSON_UNESCAPED_UNICODE);
        }
    }
    // создание товара

} else {

    http_response_code(400);


    echo json_encode(array("message" => "Невозможно создать комикс. Данные неполные."), JSON_UNESCAPED_UNICODE);
}


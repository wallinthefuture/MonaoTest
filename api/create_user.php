<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once "./objects/user.php";

$jsonArray=[];

//Если файл существует - получаем его содержимое
if (file_exists('./config/database.json')) {
    $json = file_get_contents('./config/database.json');
    $jsonArray = json_decode($json, true);
}

$user = new User($jsonArray);

$data = json_decode(file_get_contents("php://input"));


if (
    !empty($data->login) &&
    !empty($data->password) &&
    !empty($data->confirm_password) &&
    !empty($data->email) &&
    !empty($data->name)

) {
    // устанавливаем значения свойств товара
    $user->login = $data->login;
    $user->password = $data->password;
    $user->confirm_password = $data->confirm_password;
    $user->email = $data->email;
    $user->name = $data->name;

    // создание товара
    if ($user->create()) {
        // установим код ответа - 201 создано
        http_response_code(201);

        // сообщим пользователю
        echo json_encode(array("message" => "Комикс был создан."), JSON_UNESCAPED_UNICODE);
    } else {

        http_response_code(503);


        echo json_encode(array("message" => "Невозможно создать комикс."), JSON_UNESCAPED_UNICODE);
    }
} else {

    http_response_code(400);


    echo json_encode(array("message" => "Невозможно создать комикс. Данные неполные."), JSON_UNESCAPED_UNICODE);
}


<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "./config/database.php";
include_once "./objects/user.php";
include_once "generate_sault.php";


//Если файл существует - получаем его содержимое
$db = new Database();

$user = new User($db->getUsers());

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->login) &&
    !empty($data->psw)
) {

    // устанавливаем значения свойств товара
    $user->login = htmlspecialchars(strip_tags($data->login));
    $user->password = htmlspecialchars(strip_tags($data->psw));
//    echo json_encode($db);
    if ($user->checkLoginAndPassword()) {

        http_response_code(400);
        echo json_encode(array("message" => "Вы ввели неправильный логин или пароль."), JSON_UNESCAPED_UNICODE);
    } else {

        session_start();
        echo json_encode( $_SESSION['login']);
        //Пишем в сессию информацию о том, что мы авторизовались:
        $_SESSION['auth'] = true;
        $_SESSION['login'] = $user->login;


        if (!empty($data->remember) && $data->remember == 1) {

            $key = generateSalt();

            setcookie('login', $user->login, time() + 60 * 60 * 24 * 30); //логин
            setcookie('key', $key, time() + 60 * 60 * 24 * 30); //случайная строка
            $db->updateCookie($key, $user->login);

        }

        http_response_code(201);


    }
} else {

    http_response_code(400);


    echo json_encode(array("message" => "Невозможно создать комикс. Данные неполные."), JSON_UNESCAPED_UNICODE);
}



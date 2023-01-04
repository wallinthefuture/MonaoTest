<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "./objects/user.php";
function generateSalt()
{
    $salt = '';
    $saltLength = 8; //длина соли
    for ($i = 0; $i < $saltLength; $i++) {
        $salt .= chr(mt_rand(33, 126)); //символ из ASCII-table
    }
    return $salt;
}

$jsonArray = [];

//Если файл существует - получаем его содержимое
if (file_exists('./config/database.json')) {
    $json = file_get_contents('./config/database.json');
    $jsonArray = json_decode($json, true);
}
$data = json_decode(file_get_contents("php://input"));
$user = new User($jsonArray);


if (
    !empty($data->login) &&
    !empty($data->psw)
) {

    // устанавливаем значения свойств товара
    $user->login = htmlspecialchars(strip_tags($data->login));
    $user->password = htmlspecialchars(strip_tags($data->psw));
    if ($user->checkLoginAndPassword()) {
        http_response_code(400);
        echo json_encode(array("message" => "Вы ввели неправильный логин или пароль."), JSON_UNESCAPED_UNICODE);
    } else {

        session_start();

        //Пишем в сессию информацию о том, что мы авторизовались:
        $_SESSION['auth'] = true;
        $_SESSION['login'] = $user->login;


        if (!empty($data->remember) && $data->remember == 1) {

            $key = generateSalt();

            setcookie('login', $user->login, time() + 60 * 60 * 24 * 30); //логин
            setcookie('key', $key, time() + 60 * 60 * 24 * 30); //случайная строка

            $user->updateCookie($key);

        }

        http_response_code(201);


    }
} else {

    http_response_code(400);


    echo json_encode(array("message" => "Невозможно создать комикс. Данные неполные."), JSON_UNESCAPED_UNICODE);
}


<?php
$db = new mysqli('192.168.199.13', 'learn','learn','learn_vershininmp-is64') or die('error');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    
    $result = $db->query("SELECT COUNT(*) AS count FROM users WHERE email = '$email'");
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        die('Email уже используется!');

    }

    // Добавление нового пользователя
    
    if ($db->query("INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', 'user')")) {
        echo 'Регистрация прошла успешно!';
    } else {
        echo 'Ошибка: ' . $db->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Регистрация</h2>
    <form  method="post">
        <input name = "username" type="text" placeholder = "Имя">
        <input name = "email" type="email" placeholder = "Email">
        <input name = "password" type="password" placeholder = "Пароль">
        <input type="submit" value="Зарегистрироваться">
    </form>
</body>
</html>
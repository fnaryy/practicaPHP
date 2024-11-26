<?php
session_start();

$db = new mysqli('192.168.199.13', 'learn', 'learn', 'learn_vershininmp-is64') or die('error');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];



    $result = $db->query("SELECT * FROM users WHERE email = '$email'");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            echo 'Добро пожаловать ' . $user['username'];

            session_start();
            $_SESSION['user_id'] = $user['id'];

            header("Location: post.php");
            exit();
        } else {
            echo 'Неверный пароль';
        }
    } else {
        echo 'Пользователь не найден';
    }


}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Вход</title>
</head>

<body>
    <h2>Авторизация</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit" name="login">Войти</button>
    </form>
</body>

</html>
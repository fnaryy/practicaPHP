<?php


$db = new mysqli('192.168.199.13', 'learn', 'learn', 'learn_vershininmp-is64') or die('error');

session_start();
if (!isset($_SESSION['user_id'])) {
    die('Вы не авторизованы!');
}

$user_id = $_SESSION['user_id'];

$result = $db->query("SELECT username FROM users WHERE id = $user_id");
if ($result) {
    $user = $result->fetch_assoc();
    $current_username = $user['username'];
} else {
    die('Ошибка получения данных пользователя: ' . $db->error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    $query = "UPDATE users SET username = '$username', email = '$email'";
    if ($password) {
        $query .= ", password = '$password'";
    }
    $query .= " WHERE id = $user_id";

    if ($db->query($query)) {
        echo 'Данные успешно обновлены!';
    } else {
        echo 'Ошибка: ' . $db->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Редактирование</title>
</head>
<body>
    <h2>Редактирование</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Новый пароль">
        <button type="submit">Обновить</button>
    </form>
    <p>Вы сейчас под именем <?php echo htmlspecialchars($current_username); ?></p>
</body>
</html>

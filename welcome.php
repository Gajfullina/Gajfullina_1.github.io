<?php
session_start();

// Проверка, вошел ли пользователь в систему
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добро пожаловать</title>
</head>
<body>
    <h2>Добро пожаловать, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
    <p>Вы успешно вошли в систему.</p>
    <a href="logout.php">Выйти</a>
</body>
</html>
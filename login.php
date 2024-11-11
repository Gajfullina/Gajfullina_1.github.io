<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Подключение к базе данных
    $servername = "localhost"; // Обычно localhost
    $username = "ваше_имя_пользователя"; // Ваше имя пользователя
    $password_db = "ваш_пароль"; // Ваш пароль
    $dbname = "ваша_база_данных"; // Название вашей базы данных

    // Создание соединения
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Проверка соединения
    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    // SQL-запрос для получения пользователя по email
    $sql = "SELECT * FROM users WHERE email = ?";
    
    // Подготовка и выполнение запроса
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Получаем данные пользователя
        $user = $result->fetch_assoc();
        
        // Проверка пароля
        if (password_verify($password, $user['password'])) {
            // Успешный вход
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['fio']; // Сохраняем имя пользователя (или другие данные)

            header("Location: welcome.php"); // Перенаправление на страницу приветствия
            exit();
        } else {
            // Неверный пароль
            header("Location: login.php?error=Неверный пароль");
            exit();
        }
    } else {
        // Пользователь не найден
        header("Location: login.php?error=Пользователь не найден");
        exit();
    }

    // Закрытие соединения
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
</head>
<body>
    <h2>Форма авторизации</h2>
    <?php
    // Вывод сообщения об ошибке, если оно существует
    if (isset($_GET['error'])) {
        echo '<p style="color:red;">' . htmlspecialchars($_GET['error']) . '</p>';
    }
    ?>
    <form action="login.php" method="post">
        <label for="email">Электронная почта:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Пароль:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Войти</button>
    </form>
</body>
</html>
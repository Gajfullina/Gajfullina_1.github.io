<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $fio = $_POST['fio'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Хэшируем пароль
    $department = $_POST['department'];

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

    // SQL-запрос для вставки данных
    $sql = "INSERT INTO users (fio, phone, email, password, department) VALUES (?, ?, ?, ?, ?)";
    
    // Подготовка и выполнение запроса
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $fio, $phone, $email, $password, $department);

    if ($stmt->execute()) {
        echo "Регистрация прошла успешно!";
    } else {
        echo "Ошибка: " . $stmt->error;
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
    <title>Регистрация</title>
    <link  rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="host/css/master.css">
</head>
<body>
    <div class="containert mt-4">
    <h2>Форма регистрации</h2>
    <form action="register.php" method="post">
        <label for="fio">ФИО:</label><br>
        <input type="text" class="form-control" name="fio" id="fio" placeholder="Введите ФИО" required><br><br>

        <label for="phone">Телефон:</label><br>
        <input type="text" class="form-control" name="phone" id="phone" placeholder="Введите номер телефона" required><br><br>

        <label for="email">Электронная почта:</label><br>
        <input type="email" class="form-control" name="email" id="email" placeholder="Введите электронную почту" required><br><br>

        <label for="password">Пароль:</label><br>
        <input type="password" class="form-control" name="password" id="password" placeholder="Введите электронную почту" required><br><br>
        <button class="btn btn-success">Зарегистрироваться</button>
</body>
</html>
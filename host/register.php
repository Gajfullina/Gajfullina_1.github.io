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
</head>
<body>
    <h2>Форма регистрации</h2>
    <form action="register.php" method="post">
        <label for="fio">ФИО:</label><br>
        <input type="text" id="fio" name="fio" required><br><br>

        <label for="phone">Телефон:</label><br>
        <input type="text" id="phone" name="phone" required><br><br>

        <label for="email">Электронная почта:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Пароль:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="department">Отдел:</label><br>
        <select id="department" name="department" required>
            <option value="IT">IT</option>
            <option value="HR">HR</option>
            <option value="Sales">Продажи</option>
            <!-- Добавьте другие отделы по мере необходимости -->
        </select><br><br>

        <button type="submit">Зарегистрироваться</button>
    </form>
</body>
</html>
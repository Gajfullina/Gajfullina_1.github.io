<?php
$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);

if(mb_strlen($login) < 5 || mb_strlen($login) > 90) {
    echo "Недопустимая длина логина";
    exit();
} else if(mb_strlen($name) < 3 || mb_strlen($name) > 50) {
    echo "Недопустимая длина имени";
exit();
} else if(mb_strlen($pass) < 2 || mb_strlen($pass) > 6) {
    echo "Недопустимая длина пароля (от 2 до 6 символов)";
exit();
}

$pass= md5($pass. "lol");

$mysql = new mysqli('localhost', 'root', '', 'register-bd');
$mysql->query("INSERT INTO `users` (`login`, `pass`, `name`) VALUES('$login', '$pass', '$name')");

$mysql->close();
header('Location: /');
?>
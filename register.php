<?php
session_start();

// Проверяем, была ли отправлена форма методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверяем, были ли переданы все необходимые поля
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['third_name'])) {
        // Получаем данные из формы
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $name = ucfirst($_POST['name']);
        $surname = ucfirst($_POST['surname']);
        $third_name = ucfirst($_POST['third_name']);
				

        // Проверяем, совпадают ли пароли
        if ($password !== $confirm_password) {						
						header("Location: index.php?success=6");
            exit();
        }

        // Подключение к базе данных
        $mysqli = new mysqli("localhost", "root", "", "task_manager");

        // Проверяем, существует ли пользователь с таким же логином или email
        $stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        // Если пользователь существует, выводим сообщение об ошибке
        if ($stmt->num_rows > 0) {
						header("Location: index.php?success=5");
            exit();
        }

        // Закрываем запрос
        $stmt->close();

        // Хэшируем пароль
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Подготовка запроса для добавления нового пользователя
        $stmt = $mysqli->prepare("INSERT INTO users (username, email, password, name, surname, third_name) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $username, $email, $hashed_password, $name, $surname, $third_name);

        // Выполнение запроса
        if ($stmt->execute()) {
            header("Location: index.php?success=3");
            exit();
        } else {
            echo "Ошибка при регистрации: " . $stmt->error;
            header("Location: index.php");
            exit();
        }

        // Закрытие соединения
        $stmt->close();
        $mysqli->close();
    } else {
        echo "Не все поля были заполнены.";
        exit();
    }
}
?>

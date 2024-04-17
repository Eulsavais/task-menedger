<?php
// Файл: create_task.php

session_start();

// Проверка, вошел ли пользователь в систему
if (!isset($_SESSION['user_id'])) {
    echo "Вы не вошли в систему!";
    exit();
}

// Подключение к базе данных
$mysqli = new mysqli("localhost", "root", "", "task_manager");

// Получение данных из формы
$title = $_POST['title'];
$description = $_POST['description'];
$assignee_id = $_POST['assignee_id'];
$creator_id = $_SESSION['user_id'];
$due_date = $_POST['due_date'];

if (empty($title) || empty($description) || empty($assignee_id) || empty($due_date)) {
	header("Location: index.php?success=7");
	exit();
}

// Подготовка запроса
$stmt = $mysqli->prepare("INSERT INTO tasks (title, description, due_date, date_from, creator_id, assignee_id) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssii", $title, $description, $due_date, date('Y-m-d'), $creator_id, $assignee_id);

// Выполнение запроса
if ($stmt->execute()) {
		header("Location: index.php?success=4");
				exit();
} else {
    echo "Ошибка при создании задачи: " . $stmt->error;
}

// Закрытие соединения
$stmt->close();
$mysqli->close();
?>

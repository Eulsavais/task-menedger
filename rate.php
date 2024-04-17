<?php
session_start();

// Проверяем, был ли отправлен запрос методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверяем, была ли передана переменная update_status
    if (isset($_POST["rate"])) {
        // Проверяем, был ли передан идентификатор задачи
        if (isset($_POST["task_id"])) {
            // Получаем идентификатор задачи из параметров запроса
            $task_id = $_POST["task_id"];
						$task_rate = $_POST["task_rate"];
						$username = $_POST["username"];
						$rate_comment = $_POST["rate_comment"];
						$page = $_POST["page"];
            // Подключение к базе данных
            $mysqli = new mysqli("localhost", "root", "", "task_manager");

            // Подготовка запроса для обновления статуса задачи					
							$stmt = $mysqli->prepare("INSERT INTO rates (task_id, task_rate, comment) VALUES (?, ?, ?)");
            	$stmt->bind_param("iss", $task_id, $task_rate, $rate_comment);							  

            // Выполнение запроса
            $stmt->execute();

            // Закрытие соединения
            $stmt->close();
            $mysqli->close();

            // Перенаправление на страницу с задачами
           
						if (isset($username)) {
							header('Location: '.$page.'?username='.$username);				
							exit();
						} else {
							header('Location: '.$page.'');				
							exit();
						}
        }
    }
}
?>

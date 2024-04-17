<?php
session_start();

// Проверяем, был ли отправлен запрос методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверяем, была ли передана переменная update_status
    if (isset($_POST["update_status"])) {
        // Проверяем, был ли передан идентификатор задачи
        if (isset($_POST["task_id"])) {
            // Получаем идентификатор задачи из параметров запроса
            $task_id = $_POST["task_id"];
						$change_task = $_POST["change_task"];
						$username = $_POST["username"];
						$page = $_POST["page"];
						$answer = $_POST["answer"];
            // Подключение к базе данных
            $mysqli = new mysqli("localhost", "root", "", "task_manager");
						$current_date = date('Y-m-d');

            // Подготовка запроса для обновления статуса задачи
						if ($change_task == 'закрыть') { 						
							$stmt = $mysqli->prepare("UPDATE tasks SET status = 'закрыта', date_end = '".$current_date."' WHERE id = ?");
            							
						} else if ($change_task == 'отменить') {
							$stmt = $mysqli->prepare("UPDATE tasks SET status = 'отменена', date_end = '".$current_date."' WHERE id = ?");
            
						} else if ($change_task == 'выполнить') {
							$stmt = $mysqli->prepare("UPDATE tasks SET status = 'на проверке', date_perform = '".$current_date."', comment = '".$answer."' WHERE id = ?");
            	
						} else if ($change_task == 'обратно') {
							$stmt = $mysqli->prepare("UPDATE tasks SET status = 'в работе', date_perform = null WHERE id = ?");
            	
						}
            $stmt->bind_param("i", $task_id);	

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

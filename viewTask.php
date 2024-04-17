<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="main.css">
	<link rel="stylesheet" href="form.css">

	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js" defer></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js" defer></script>

	<title>TaskMenedger</title>
</head>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js" defer></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js" defer></script>
<?php
session_start();

// Проверка, вошел ли пользователь в систему
if (!isset($_SESSION['user_id'])) {
    echo "Вы не вошли в систему!";
    exit();
}

// Проверяем, был ли отправлен запрос методом GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Проверяем, был ли передан параметр username
    if (isset($_GET["username"])) {
        // Подключение к базе данных
        $mysqli = new mysqli("localhost", "root", "", "task_manager");

        // Получаем имя пользователя из параметров запроса
        $username = $_GET["username"];


        // Подготовка запроса для получения ID пользователя по его имени
        $stmt_user_id = $mysqli->prepare("SELECT id, name, surname, third_name FROM users WHERE username = ?");
        $stmt_user_id->bind_param("s", $username);
        $stmt_user_id->execute();
        $stmt_user_id->bind_result($user_id, $name, $surname, $third_name);
        $stmt_user_id->fetch();
        $stmt_user_id->close();
				// users.username AS assigner_username
        // Подготовка запроса для выборки задач для указанного пользователя
        $stmt = $mysqli->prepare("SELECT tasks.id, tasks.title, tasks.description, tasks.due_date, tasks.date_from, tasks.date_perform, tasks.date_end, tasks.status, tasks.comment, tasks.creator_id, tasks.assignee_id, users.username AS assigner_username, CONCAT(users.name, ' ', users.surname, ' ', users.third_name) AS full_name FROM tasks INNER JOIN users ON tasks.creator_id = users.id WHERE tasks.assignee_id = ? ORDER BY tasks.id DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
				
			include('header.php');

        echo "
				<div class='_container'>
				<div class='content'>
				<section class='myTasks'>
				<h2 style='margin-bottom: 20px;'>Задачи для $name $surname $third_name:</h2>";
        if ($result->num_rows > 0) {			

					print "<section class=task-cards_container>";
            while ($row = $result->fetch_assoc()) {
							if ($row['status'] == 'на проверке') {
								$class_status = 'checking';
							} else if ($row['status'] == 'в работе') {
								$class_status = 'in_work';
							} else {
								$class_status = 'done';
							}

							$r_date_perform  = (empty($row['date_perform'])) ? '...' : $row['date_perform'];
							$r_date_end = (empty($row['date_end'])) ? '...' : $row['date_end'];

							$stmt_rate = $mysqli->prepare("SELECT task_rate, comment FROM rates WHERE task_id = ?");
							$stmt_rate->bind_param("i", $row['id']);
							$stmt_rate->execute();
							$stmt_rate->bind_result($task_rate, $rate_comment);
							$stmt_rate->fetch();
							$stmt_rate->close();

							$stmt_creator = $mysqli->prepare("SELECT username FROM users WHERE id = ?");
							$stmt_creator->bind_param("i", $row['creator_id']);
							$stmt_creator->execute();
							$stmt_creator->bind_result($creator_username);
							$stmt_creator->fetch();
							$stmt_creator->close();

                print '
								<div class="task-card '.$class_status.'">
										<div class="task_left_side">
											<div class="description">
												<div class="title_desc">'. $row['title'] .'</div>
												<div class="subtitle_desc">'. $row['description'] .'</div>
											</div>
											<div class="task_from">
											От '. $row['full_name'] .'
											</div>
										</div>
										<div class="task_right_side">
											<div class="task_from_date">Дата создания задачи: <strong>'.$row['date_from'].'</strong></div>
											<div class="task_status">Статус задачи: <strong>'. $row['status'] .'</strong></div>
											<div class="task_due_date">Дата планируемого выполнения: <strong>'. $row['due_date'] .'</strong></div>
											<div class="task_perform_date">Дата выполнения: <strong>'.$r_date_perform.'</strong></div>
											<div class="task_end_date">Дата закрытия: <strong>'.$r_date_end.'</strong></div>';
											
											if (!empty($row['comment'])) {
												print '
													<div class=comment>
														<div class="comment_title">Комментарий к задаче:</div>
														<div class="comment_text">'.$row['comment'].'</div>
													</div>';
											};

											
											if (($row['assigner_username'] == $_SESSION['username']) && ($row['status'] == 'на проверке')) print '
											<form action="updateTaskStatus.php" method=post>
												<input type=hidden name=task_id value=' . $row['id'] . '>
												<input type=hidden name=change_task value=закрыть>
												<input type=hidden name=username value='.$username.'>
												<input type=hidden name=page value="viewTask.php">
												<button class="btn-perform" type="submit" name="update_status" value="complete">закрыть задачу</button>
											</form>
											<form action="updateTaskStatus.php" method=post>
												<input type=hidden name=task_id value=' . $row['id'] . '>
												<input type=hidden name=change_task value=обратно>
												<input type=hidden name=username value='.$username.'>
												<input type=hidden name=page value="viewTask.php">
												<button class="btn-perform" type="submit" name="update_status" value="complete">Отправить обратно</button>			
											</form>
											
											';
											if (($row['assigner_username'] == $_SESSION['username']) && ($row['status'] == 'в работе')) print '
											<form action="updateTaskStatus.php" method=post>
												<input type=hidden name=task_id value=' . $row['id'] . '>
												<input type=hidden name=change_task value=отменить>
												<input type=hidden name=username value='.$username.'>
												<input type=hidden name=page value="viewTask.php">
												<button class="btn-perform" type="submit" name="update_status" value="complete">отменить задачу</button>
											</form>
											';

											if (($row['assignee_id'] == $_SESSION['user_id']) && ($row['status'] == 'в работе')) print '
											<form action="updateTaskStatus.php" method=post>
												<input type=hidden name=task_id value=' . $row['id'] . '>
												<input type=hidden name=change_task value=выполнить>
												<input type=hidden name=username value='.$username.'>
												<input type=hidden name=page value="viewTask.php">
												<div class="form_item">								
													<textarea name="answer" id="answer" rows="4" cols="50" class="form_input" placeholder="Комментарий к задаче"></textarea>
												</div>
												<button class="btn-perform" type="submit" name="update_status" value="complete">выполнить задачу</button>
											</form>
											';

											if (isset($task_rate)) {
												print '<div class="comment">
												<div class=flex_c>Оценка задачи: <strong>'.$task_rate.'</strong><ion-icon name="star-outline"></ion-icon></div> 
												';
												if (empty($rate_comment)) {
													print '';
												} else {
													print '<br/>
													Комментарий: <br/>
													'.$rate_comment.'';
												}
												print '</div>';	
											} else if ($r_date_end != '...' && $_SESSION['username'] == $creator_username && $creator_username != $username) {
												print '
														<form action="rate.php" method=post>
														
															<input type=hidden name=task_id value=' . $row['id'] . '>
															<input type=hidden name=username value='.$username.'>
															<input type=hidden name=page value="viewTask.php">
															<label for="task_rate" class="form_label">Оценка задачи:</label>
															<select name=task_rate class="select" style="margin-bottom: 10px;">
															<option value="1">1 <ion-icon name="star-outline"></ion-icon></option>			
															<option value="2">2 <ion-icon name="star-outline"></ion-icon></option>
															<option value="3">3 <ion-icon name="star-outline"></ion-icon></option>
															<option value="4">4 <ion-icon name="star-outline"></ion-icon></option>
															<option value="5">5 <ion-icon name="star-outline"></ion-icon></option>
															</select>				
															<div class="form_item">								
														<textarea name="rate_comment" id="rate_comment" rows="4" cols="50" class="form_input" placeholder="Комментарий к оценке"></textarea>
													</div>		
															<button class="btn-perform btn-rate" type="submit" name="rate" value="complete">оценить задачу</button>
														</form>
														';
											}
										

											$task_rate = null;

									print '</div>
									</div>';
            }
						print "</section>";
        } else {
            echo "
						<div class='myTasks'>
						
						Нет задач для этого пользователя.
						
						</div>
						</div>
						</div>
						";
        }

        // Закрытие соединения
        $stmt->close();
        $mysqli->close();
    }
}
?>

<?php
		include('popups.php');
		include('libraries.php');
?>



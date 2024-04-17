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
			include('header.php');
		?>

		<main class="main">
			<div class="_container">
				<div class="content">
				<section class="myTasks">
					<?php
						if (session_status() == PHP_SESSION_NONE) {
							session_start();
						}

						// Получение ID пользователя из параметров запроса
						$user_id = $_SESSION['user_id'];
						
						// Подключение к базе данных
						$mysqli = new mysqli("localhost", "root", "", "task_manager");
						
						// Подготовка запроса для выборки задач для указанного пользователя
						$stmt = $mysqli->prepare("SELECT tasks.id, tasks.title, tasks.description, tasks.due_date, tasks.date_from, tasks.date_perform, tasks.date_end, tasks.status, tasks.comment, tasks.creator_id, tasks.assignee_id, users.username AS assigner_username, CONCAT(users.name, ' ', users.surname, ' ', users.third_name) AS full_name FROM tasks INNER JOIN users ON tasks.creator_id = users.id WHERE tasks.creator_id = ? ORDER BY tasks.id DESC");
						$stmt->bind_param("i", $user_id);
						
						// Выполнение запроса
						$stmt->execute();
						$result = $stmt->get_result();
						
						// Отображение задач
						print "<h2 style='margin-bottom: 20px;'>Назначенные задачи:</h2>
						
						";


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

								$stmt_as_name = $mysqli->prepare("SELECT CONCAT(users.name, ' ', users.surname, ' ', users.third_name) AS as_full_name, users.username FROM users, tasks WHERE users.id = ?");
								$stmt_as_name->bind_param("i", $row['assignee_id']);
								$stmt_as_name->execute();
								$stmt_as_name->bind_result($as_full_name, $as_username);
								$stmt_as_name->fetch();
								$stmt_as_name->close();

								print '
									<div class="task-card '.$class_status.'">
										<div class="task_left_side">
											<div class="description">
												<div class="title_desc">'. $row['title'] .'</div>
												<div class="subtitle_desc">'. $row['description'] .'</div>
											</div>
											<div class="task_from">
											Исполнитель: '. $as_full_name .'
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

											if (($row['assigner_username'] == $_SESSION['username']) && ($row['status'] == 'в работе')) print '
											<form action="updateTaskStatus.php" method=post>
												<input type=hidden name=task_id value=' . $row['id'] . '>
												<input type=hidden name=change_task value=отменить>
												<input type=hidden name=page value="assignedTask.php">
												<button class="btn-perform" type="submit" name="update_status" value="complete">отменить задачу</button>
											</form>
											';
											if (($row['assigner_username'] == $_SESSION['username']) && ($row['status'] == 'на проверке')) print '
											<form action="updateTaskStatus.php" method=post>
												<input type=hidden name=task_id value=' . $row['id'] . '>
												<input type=hidden name=change_task value=закрыть>
												<input type=hidden name=page value="assignedTask.php">
												<button class="btn-perform" type="submit" name="update_status" value="complete">закрыть задачу</button>
											</form>
											<form action="updateTaskStatus.php" method=post>
												<input type=hidden name=task_id value=' . $row['id'] . '>
												<input type=hidden name=change_task value=обратно>
												<input type=hidden name=username value="assignedTask.php">
												<input type=hidden name=page value="assignedTask.php">
												<button class="btn-perform" type="submit" name="update_status" value="complete">Отправить обратно</button>			
											</form>
											';
											

											if (($row['assignee_id'] == $_SESSION['user_id']) && ($row['status'] == 'в работе')) print '
											<form action="updateTaskStatus.php" method=post>
												<input type=hidden name=task_id value=' . $row['id'] . '>
												<input type=hidden name=change_task value=выполнить>
												<input type=hidden name=page value="assignedTask.php">
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
											} else if ($r_date_end != '...' && $_SESSION['username'] == $creator_username && $creator_username != $as_username) {
												print '
												<form action="rate.php" method=post>
												
													<input type=hidden name=task_id value=' . $row['id'] . '>
												
													<input type=hidden name=page value="assignedTask.php">
													<label for="task_rate" class="form_label">Оценка задачи:</label>
													<select name=task_rate class="select" style="margin-bottom: 10px;">
													<option value="1">1 звезда</option>			
													<option value="2">2 звезды</option>
													<option value="3">3 звезды</option>
													<option value="4">4 звезды</option>
													<option value="5">5 звезд</option>
													</select>			
													<div class="form_item">								
														<textarea name="rate_comment" id="rate_comment" rows="4" cols="50" class="form_input" placeholder="Комментарий к оценке"></textarea>
													</div>			
													<button class="btn-perform btn-rate" type="submit" name="rate" value="complete">оценить задачу</button>
												</form>
												';
											}
											$task_rate = null;
																			
									print '
										</div>
									</div>
									';				

									
								}
								print "</section>";
						} else {
							print "Вы пока не назначили не кому задачу.";
						}
						
						// Закрытие соединения
						$stmt->close();
						$mysqli->close();
					?>
				</section>

			
				</div>
			</div>
		</main>

	<?php
		include('popups.php');
		include('libraries.php');
	?>
</body>

</html>
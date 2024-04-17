<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js" defer></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js" defer></script>

	<title>TaskMenedger</title>
</head>

<body>
		<?php 
			require('header.php');
		?>

		<main class="main">
			<div class="_container">
				<div class="content">
				<?php if (isset($_SESSION['user_id'])): ?>
				<section class="set">
					
					<h2 class="setGetHeader">Добавить задачу</h2>
					
					<form action="createTask.php" method="post">
						
						<div class="form_item">
							<label class="form_label" for="assignee_id">Исполнитель:</label>
							<select name="assignee_id" id="assignee_id" class="select">
									<?php
									session_start();
									$current_user_id = $_SESSION['user_id'];
									
									$mysqli = new mysqli("localhost", "root", "", "task_manager");
									$result = $mysqli->query("SELECT id, username, name, surname, third_name FROM users");
									while ($row = $result->fetch_assoc()) {									
											if (empty($row['third_name'])) {
												echo "<option value=\"" . $row['id'] . "\">" .$row['name'].' '.$row['surname']."</option>";
											} else echo "<option value=\"" . $row['id'] . "\">" .$row['name'].' '.$row['surname'].' '.$row['third_name']. "</option>";
									}
									$mysqli->close();
									?>
							</select>
						</div>
						<div class="form_item">
							<label for="title" class="form_label">Заголовок:</label><br>
							<textarea name="title" id="title" rows="4" cols="50" class="form_input" placeholder="Введите заголовок задачи"></textarea>
						</div>
						<div class="form_item">
							<label for="description" class="form_label">Описание:</label><br>
							<textarea name="description" id="description" rows="4" cols="50" class="form_input" placeholder="Опишите задачу"></textarea>
						</div>
						<div class="form_item">
							<label for="due_date" class="form_label">Срок выполнения:</label>
							<input class="date" type="date" id="due_date" name="due_date">
						</div>
						
						<input type="submit" value="Создать задачу" class="form_button_task">
					</form>
					
				</section>
					<section class="get">
					
						<h2 class="setGetHeader">Просмотр задач</h2>
						<form action="viewTask.php" method="get">
								<div class="form_item">
									<label for="username" class="form_label">ФИО пользователя:</label>
									<select name="username" class="select">
										<!-- Пункты выбора имени пользователя -->
										<?php
											// Подключение к базе данных
											$mysqli = new mysqli("localhost", "root", "", "task_manager");
											
											// Получение списка пользователей
											$result = $mysqli->query("SELECT id, username, name, surname, third_name FROM users");
											
											// Отображение пунктов выбора
											while ($row = $result->fetch_assoc()) {
													if (empty($row['third_name'])) {
														echo "<option value=\"" . $row['username'] . "\">" .$row['name'].' '.$row['surname']."</option>";
													} else echo "<option value=\"" . $row['username'] . "\">" .$row['name'].' '.$row['surname'].' '.$row['third_name']. "</option>";
											}
											$mysqli->close();
										?>
									</select>
								</div>
								<input type="submit" value="Показать задачи" class="form_button_task">
						</form>

					</section>

					<?php else: ?>
							<div class="unlog">
								<p class="unlog_title">Пожалуйста, войдите, чтобы добавить или просмотреть задачи.</p>
								<a href="#popup" class="auto__link popup-link">Войти</a>
								<a href="#popupReg" class="reg__link popup-link">Зарегистрироваться</a>
							</div>
					<?php endif; ?>
				</div>
					
			</div>
		</main>
				
	<?php
		require('popups.php');
		require('libraries.php');
	?>
		
</body>

</html>

<link rel="stylesheet" href="styles/main.css">
<link rel="stylesheet" href="styles/form.css">

<div class="wrapper">
		<header class="header">
			<div class="_container">
				<div class="header_con">
					<nav class="header_menu">
					<a href="index.php" class="logo">TaskMenedger</a>
					<?php
							if (session_status() == PHP_SESSION_NONE) {
								session_start();
							}
														
							if(isset($_SESSION["username"]))
							{
								$mysqli = new mysqli("localhost", "root", "", "task_manager");
								$status1 = 'в работе';
								$status2 = 'на проверке';
								$my_task_count = $mysqli->prepare("SELECT COUNT(*) AS count FROM tasks WHERE assignee_id = ? and (status = ? or status = ?)");
								$my_task_count->bind_param("iss", $_SESSION['user_id'], $status1, $status2);
								$my_task_count->execute();
								$my_task_count->bind_result($count_tasks);
								$my_task_count->fetch();
								$my_task_count->close();

								print '<ul class="menu_list">';
								if ($count_tasks > 0) {
									print '
									<div class=tasks_counter_wrap>
										<div class=tasks_counter>'.$count_tasks.'</div>
										<a href="myTasks.php" class="menu_link">Мои задачи</a>
									</div>';
								} else {
									print '<a href="myTasks.php" class="menu_link">Мои задачи</a>';
								}					
								print '	
									<a href="dashboard.php" class="menu_link">Дашборд</a>
									<a href="assignedTask.php" class="menu_link">Назначенные задачи</a>
								</ul>
								<div class=mobile_bar>
									<div class="burger_menu">
										<div></div>
										<div></div>
										<div></div>
									</div>
								</div>
							';
							}
						?>	
						</nav>				
					
					<div class="auto_block">
						<?php
							if (session_status() == PHP_SESSION_NONE) {
								session_start();
							}
														
							if(isset($_SESSION["username"]))
							{
								print '<div class="username">'.$_SESSION["username"].'</div>';
								print '<a href="exit.php" class="auto__link">Выход</a>';
							}
					
						?>					
					</div>
				</div>
			</div>
		</header>

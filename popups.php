<div id="popup" class="popup">
			<div class="popup_body">
				<div class="popup_content">
					<a href="#header" class="popup_close close-popup">
						<ion-icon name="close-circle-outline"></ion-icon>
					</a>
					<div class="form">
						<form action="login.php" method=post class="form_body" onsubmit="return validateFormLog()">
							<h1 class="form_title">Вход</h1>
							<div class="form_item">
								<label for="email" class="form_label">Email:</label>
								<input type="email" id="emailLog" name="email" class="form_input" required>
							</div>
							<div class="form_item">
								<label for="password" class="form_label">Пароль:</label>
								<input type="password" id="passwordLog" name="password" class="form_input" required>
							</div>

							<input type="submit" value=ok class="form_button"> </input>

						</form>

						<a href="#popupReg" class="popup-link mini__auto">Зарегистрироваться</a>


					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="popupReg" class="popup">
		<div class="popup_body">
			<div class="popup_content">
				<a href="#header" class="popup_close close-popup">
					<ion-icon name="close-circle-outline"></ion-icon>
				</a>
				<div class="form">
					<form action="register.php" method=post id="form" class="form_body" onsubmit="return validateForm()">


						<h1 class="form_title">Регистрация</h1>
						<div class="form_item">
							<label for="email" class="form_label">E-mail:</label>
							<input type=email name="email" id="email" value="" class="form_input" required>
						</div>
						<div class="form_item">
							<label for="username" class="form_label">Логин:</label>
							<input type=username name="username" id="username" value="" class="form_input" required>
						</div>
						<div class="form_item">
							<label for="name" class="form_label">Имя:</label>
							<input type=name name="name" id="name" value="" class="form_input" required>
						</div>
						<div class="form_item">
							<label for="surname" class="form_label">Фамилия:</label>
							<input type=surname name="surname" id="surname" value="" class="form_input" required>
						</div>
						<div class="form_item">
							<label for="third_name" class="form_label">Отчество:</label>
							<input type=third_name name="third_name" id="third_name" value="" class="form_input">
						</div>
						<div class="form_item">
							<label for="password" class="form_label">Пароль:</label>
							<input type=password name="password" id="password" class="form_input" required>
						</div>
						
						<div class="form_item">
							<label for="confirm_password" class="form_label">Повтор пароля:</label>
							<input type=password name="confirm_password" id="confirm_password" class="form_input" required>
						</div>
						<input type="submit" value=ok class="form_button"> </input>

					</form>


					<a href="#popup" class="popup-link mini__auto">Войти</a>

				</div>
			</div>
		</div>
	</div>

	<div id="success" class="popup suc">
		<div class="popup_body suc">
			<div class="popup_content suc">				
				<div class="success_body">
					<div class="upper_text"></div>
				</div>
			</div>
		</div>
	</div>

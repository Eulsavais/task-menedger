function extractNumber(str) {
	// Находим индекс символа '='
	var index = str.indexOf('=');

	// Если символ '=' найден
	if (index !== -1) {
		// Извлекаем подстроку, начиная с символа '=' до конца строки
		var numberStr = str.substring(index + 1);

		// Пытаемся преобразовать извлеченную подстроку в число
		var number = parseInt(numberStr, 10);

		// Проверяем, что преобразование прошло успешно и возвращаем число
		if (!isNaN(number)) {
			return number;
		}
	}

	// Возвращаем null, если число не найдено
	return null;
}


const Url = window.location.href;

function ale() {
	alert('hello')
}

function successMsg() {

	if (Url.includes('success')) {
		const successNum = extractNumber(Url);
		const popupElement = document.getElementById('success');
		let newText;



		if (popupElement) {
			switch (successNum) {
				case 0:
					newText = 'Вход выполнен успешно!';
					break;
				case 1:
					newText = 'Пользователь не найден!';
					break;
				case 2:
					newText = 'Неправильный пароль!';
					break;
				case 3:
					newText = 'Регистрация прошла успешно!';
					break;
				case 4:
					newText = 'Задача успешно создана!';
					break;
				case 5:
					newText = 'Пользователь с таким логином или email уже существует!';
					break;
				case 6:
					newText = 'Пароли не совпадают!';
					break;
				case 7:
					newText = 'Заполните все поля!';
					break;
				default:
					newText = 'Что-то пошло не так :('
			}

			popupElement.querySelector('.upper_text').innerText = newText;

			popupElement.classList.add('open');

			setTimeout(() => {
				popupElement.classList.remove('open');
				window.history.replaceState({}, document.title, Url.slice(0, -10));
			}, 1000)
		}


	}
};

successMsg()
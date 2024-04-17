function validateForm() {
	var username = document.getElementById("username").value;
	var email = document.getElementById("email").value;
	var password = document.getElementById("password").value;

	if (username == "" || email == "" || password == "") {
		alert("Пожалуйста, заполните все поля");
		return false;
	}
}

function validateFormLog() {
	var email = document.getElementById("emailLog").value;
	var password = document.getElementById("passwordLog").value;

	if (email == "" || password == "") {
		alert("Пожалуйста, заполните все поля");
		return false;
	}
}


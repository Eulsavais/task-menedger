// Получаем текущую дату
let currentDate = new Date();
let dueDate = document.getElementById("due_date");
// Устанавливаем минимальную дату (сегодняшняя дата)
let minDate = currentDate.toISOString().split('T')[0];
dueDate.setAttribute("min", minDate);

// Устанавливаем максимальную дату (через два года)
let maxDate = new Date();
maxDate.setFullYear(maxDate.getFullYear() + 2);
let maxDateString = maxDate.toISOString().split('T')[0];
dueDate.setAttribute("max", maxDateString);
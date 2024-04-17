const burgerMenu = document.querySelector('.burger_menu');
const menuList = document.querySelector('.menu_list');

console.log(burgerMenu)
console.log(menuList)

burgerMenu.addEventListener("click", () => {
	burgerMenu.classList.toggle('active');
	menuList.classList.toggle('active');
	body.classList.toggle('lock')
})
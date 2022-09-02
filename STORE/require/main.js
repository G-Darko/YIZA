		function yiza(){
			window.location.href="./"
		}
		 //Modo Oscuro
		 const btnSwitch = document.querySelector('#switch');

		 btnSwitch.addEventListener('click', () => {
		 	document.body.classList.toggle('dark');
		 	btnSwitch.classList.toggle('active');

		 	//Guardar el modo en Localstorage
		 	if (document.body.classList.contains('dark')){
		 		localStorage.setItem('darkMode', 'true')
		 	}else{
		 		localStorage.setItem('darkMode', 'false')
		 	}
		 });
		 //Obtener el Modo
		 if (localStorage.getItem('darkMode')=== 'true'){
		 	document.body.classList.add('dark');
		 	btnSwitch.classList.add('active');
		 }else{
		 	document.body.classList.remove('dark');
		 	btnSwitch.classList.remove('active'); 	
		 }


		let user = document.querySelector('.user')
		let userMenu = document.querySelector('.userMenu')
		user.onclick = function() {
			userMenu.classList.toggle('openMenu')
		}


		/*window.addEventListener('scroll', function(){
			var topBar = document.querySelector('.topBar');
			var header = document.querySelector('.header');
			topBar.classList.toggle('sticky', window.scrollY > 0);
			header.classList.toggle('sticky', window.scrollY > 0);
		})*/

// Si tocas fuera cierra el menu
function p(){
	if (userMenu.classList.contains('openMenu')) {
		userMenu.classList.remove('openMenu');
	}
}
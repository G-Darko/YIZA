	function subir(inFile){
			let file = document.getElementById(inFile);
			file.click();
		}

	//Cambiar imagen
	function imagenChange(files, imgs, ruta){
		const file = document.querySelector("#"+files),
	  img = document.querySelector("#"+imgs);

		// Escuchar cuando cambie
		  // Los archivos seleccionados, pueden ser muchos o uno
		  const archivos = file.files;

		  // Si no hay archivos salimos de la función y quitamos la imagen
		  if (!archivos || !archivos.length) {
		    img.src = ruta;
		    return;
		  }

		  // Ahora tomamos el primer archivo, el cual vamos a previsualizar
		  const primerArchivo = archivos[0];
		  // Lo convertimos a un objeto de tipo objectURL
		  const objectURL = URL.createObjectURL(primerArchivo);
		  // Y a la fuente de la imagen le ponemos el objectURL
		  img.src = objectURL;
	}


	//Menu Toggle
	let toggle = document.querySelector('.toggle');
	let nav = document.querySelector('.nav');
	let main = document.querySelector('.main');
	 toggle.onclick = function(){
	 	nav.classList.toggle('open');
	 	main.classList.toggle('open');
	 	p();
	 }



	 //Modo Oscuro
	 const btnSwitch = document.querySelector('#switch');
	 btnSwitch.addEventListener('click', () => {
	 	document.body.classList.toggle('dark');
	 	btnSwitch.classList.toggle('active');
	 	window.location.reload();
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
	//Añadir clases del hover al seleccionar
	const list = document.querySelectorAll('.list');
	function activeLink(){
		list.forEach((item) =>
		item.classList.remove('hovered'));
		this.classList.add('hovered');
	}
	list.forEach((item) =>
	item.addEventListener('mouseover',activeLink));

	//Sticky
	/*window.addEventListener('scroll', function(){
		var topBar = document.querySelector('.topBar');
		topBar.classList.toggle('sticky', window.scrollY > 70);
	})*/
	//Modales
	function showModal(id){
		document.getElementById(id).style.display="block";
	}
	function hideModal(id){
		document.getElementById(id).style.display="none";
	}
	//Variables de color
	let mainC = getComputedStyle(document.body).getPropertyValue('--mainC');
	let negro1 = getComputedStyle(document.body).getPropertyValue('--negro1');

	// Si tocas fuera cierra el menu
	function p(){
		if (userMenu.classList.contains('openMenu')) {
			userMenu.classList.remove('openMenu');
		}
	}

	let opciones = document.getElementById('opciones');
	function mostrar(id){
		document.getElementById(id).style.display="block";
		opciones.style.display="none";
	}
	function ocultar(id){
		document.getElementById(id).style.display="none";
		opciones.style.display="block";
	}


		function salir(){
			Swal.fire({
			  title: '¿Salir sin guardar?',
			  text: "La configuración no se ha guardado",
			  icon: 'warning',
			  showCancelButton: true,
			  showDenyButton: true,
			  confirmButtonColor: '#3085d6',
			  confirmButtonText: 'Salir y Guardar',
			  cancelButtonText: 'Cancelar',
			  denyButtonText: `Salir`,
			  background: mainC,
			  color: negro1
			}).then((result) => {
				if (result.isConfirmed) {
				   saveConfig();
				} else if (result.isDenied) {
					hideModal('config');	  
				}
			})	
		}

		

		function saveConfig(){
			let fd = new FormData();
			fd.append('nomC', document.getElementById('nomC').value);
			fd.append('metaTC', document.getElementById('metaTC').value);
			fd.append('metaDesC', document.getElementById('metaDesC').value);
			fd.append('metaClaveC', document.getElementById('metaClaveC').value);
			fd.append('propietario', document.getElementById('propietario').value);
			fd.append('direccionC', document.getElementById('direccionC').value);
			fd.append('correoC', document.getElementById('correoC').value);
			fd.append('telefonoC', document.getElementById('telefonoC').value);
			fd.append('iAdmin', document.getElementById('iAdmin').value);
			fd.append('iStore', document.getElementById('iStore').value);
			fd.append('showStock', document.getElementById('showStock').value);
			fd.append('leyenda', document.getElementById('leyenda').value);
			fd.append('iconT', document.getElementById('iconT').files[0]);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/configuracion.php', true);
			request.onload=function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					if (response.state) {
						(async () =>{
							await Swal.fire({
							  icon: 'success',
							  title: 'Guadada',
							  text: 'La configuracion se ha guardado correctamente',
							  background: mainC,
							  color: negro1
							});
							window.location.reload();
						})();

					}else{
						Swal.fire({
							  icon: 'error',
							  title: 'Error',
							  text: (response.detail),
							  background: mainC,
							  color: negro1
							});
					}
				}
			}
			request.send(fd);
		}

		function resetConfig(){
			Swal.fire({
			  title: '¿Restablecer?',
			  text: "Esto cambiará la configuración a la predeterminada",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Si, restablecer',
			  cancelButtonText: 'Cancelar',
			  background: mainC,
			  color: negro1
			}).then((result) => {
			  	if (result.isConfirmed) {
				    let fd = new FormData();
						let request = new XMLHttpRequest();
						request.open('POST', 'api/resetConfig.php', true);
						request.onload=function(){
							if (request.readyState==4 && request.status==200) {
								let response=JSON.parse(request.responseText);
								if (response.state) {
									(async () =>{
										await Swal.fire({
										  icon: 'success',
										  title: 'Restablecida',
										  text: 'La configuración se ha restablecido a la predeterminada',
										  background: mainC,
										  color: negro1
										});
										window.location.reload();
									})();

								}else{
									Swal.fire({
										  icon: 'error',
										  title: 'Error',
										  text: (response.detail),
										  background: mainC,
										  color: negro1
										});
								}
						}
					}
					request.send(fd);			  
			  }
			})	
		}

		function yiza(){
			window.location.href="./"
		}

/*console.log(mainC);
console.log(negro1)*/;



/*document.onkeypress = function (e) {
  //Obtenemos el código ASCII de la tecla pulsada
  let teclaPulsada = e.charCode;
  //console.log(teclaPulsada);
  //Validamos el rango en el que se encuentran los caracteres No permitidos
  if (teclaPulsada == 60 || teclaPulsada == 62) {
    //Con return false, bloqueamos el ingreso de estos caracteres
    Swal.fire({
		  icon: 'info',
		  title: 'Caracter no permitido',
		  text: 'Los caracteres <, > no estan permitidos',
		  background: mainC,
		  color: negro1
	});
    return false;
  }
}*/
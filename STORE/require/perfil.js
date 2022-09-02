	let opciones = document.getElementById('opciones');
	function mostrar(id){
		document.getElementById(id).style.display="block";
		opciones.style.display="none";
	}
	function ocultar(id){
		document.getElementById(id).style.display="none";
		opciones.style.display="block";
	}

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

	let correo = document.getElementById("correo");
    correo.addEventListener("keydown", function (e) {
        if (e.keyCode === 13) { 
            updateDatos();
        }
    });

    let changePass = document.getElementById("cnpass");
    changePass.addEventListener("keydown", function (e) {
        if (e.keyCode === 13) { 
            updatePass();
        }
    });

    let btnPassC = document.querySelector('.btnPass.c');
   	let pass = document.querySelector('#pass');
   	btnPassC.onclick = function (){
   	    if(pass.type === 'password'){
   	        pass.type = 'text';
   	        this.firstElementChild.name = 'eye-off-outline';
   	        btnPassC.title = 'Ocultar Contraseña';
   	    }else{
   	        pass.type = 'password';
   	        this.firstElementChild.name = 'eye-outline';
   	        btnPassC.title = 'Mostrar Contraseña';
   	    }
   	    
   	}

   	let btnPassN = document.querySelector('.btnPass.n');
   	let npass = document.querySelector('#npass');
   	btnPassN.onclick = function (){
   	    if(npass.type === 'password'){
   	        npass.type = 'text';
   	        this.firstElementChild.name = 'eye-off-outline';
   	        btnPassN.title = 'Ocultar Contraseña';
   	    }else{
   	        npass.type = 'password';
   	        this.firstElementChild.name = 'eye-outline';
   	        btnPassN.title = 'Mostrar Contraseña';
   	    }
   	    
   	}

   	let btnPassCN = document.querySelector('.btnPass.cn');
   	let cnpass = document.querySelector('#cnpass');
   	btnPassCN.onclick = function (){
   	    if(cnpass.type === 'password'){
   	        cnpass.type = 'text';
   	        this.firstElementChild.name = 'eye-off-outline';
   	        btnPassCN.title = 'Ocultar Contraseña';
   	    }else{
   	        cnpass.type = 'password';
   	        this.firstElementChild.name = 'eye-outline';
   	        btnPassCN.title = 'Mostrar Contraseña';
   	    }
   	    
   	}


    function updateDatos(){
    	let fd = new FormData();
		fd.append('nombre', document.getElementById('nombre').value);
		fd.append('ap1', document.getElementById('ap1').value);
		fd.append('ap2', document.getElementById('ap2').value);
		fd.append('user', document.getElementById('user').value);
		fd.append('correo', document.getElementById('correo').value);
		let request = new XMLHttpRequest();
		request.open('POST', 'api/User/update_datos.php', true);
		request.onload = function(){
			if (request.readyState==4 && request.status==200) {
				let response=JSON.parse(request.responseText);
				//console.log(request);
				if (response.state) {
					(async () =>{
						await Swal.fire({
						  icon: 'success',
						  title: 'Actualizado',
						  text: 'Tus datos se han actualizado correctamente',
						  background: '#232323',
						  color: '#fff',
						  toast: true,
						  position: 'bottom-end',
						  timer: 3000,
						  timerProgressBar: true
						});
						window.location.reload();

					})();
				}else{
					Swal.fire({
						  icon: 'error',
						  title: 'Error',
						  text: (response.detail),
						  background: '#232323',
						  color: '#fff'
						});
				}
			}
		}
		request.send(fd);
    }

    function updatePass(){
    	let fd = new FormData();
		fd.append('pass', document.getElementById('pass').value);
		fd.append('npass', document.getElementById('npass').value);
		fd.append('cnpass', document.getElementById('cnpass').value);
		let request = new XMLHttpRequest();
		request.open('POST', 'api/User/update_pass.php', true);
		request.onload = function(){
			if (request.readyState==4 && request.status==200) {
				let response=JSON.parse(request.responseText);
				//console.log(request);
				if (response.state) {
					(async () =>{
						await Swal.fire({
						  icon: 'success',
						  title: 'Actualizado',
						  text: 'La contraseña se ha actualizado correctamente',
						  background: '#232323',
						  color: '#fff',
						  toast: true,
						  position: 'bottom-end',
						  timer: 3000,
						  timerProgressBar: true
						});
						window.location.reload();

					})();
				}else{
					Swal.fire({
						  icon: 'error',
						  title: 'Error',
						  text: (response.detail),
						  background: '#232323',
						  color: '#fff'
						});
				}
			}
		}
		request.send(fd);
    }

    function insertDir(){
    	let fd = new FormData();
		fd.append('nex', document.getElementById('nex').value);
		fd.append('nix', document.getElementById('nix').value);
		fd.append('cp', document.getElementById('cp').value);
		fd.append('estado', document.getElementById('estado').value);
		fd.append('colonia', document.getElementById('colonia').value);
		fd.append('calle', document.getElementById('calle').value);
		fd.append('municipio', document.getElementById('municipio').value);
		let request = new XMLHttpRequest();
		request.open('POST', 'api/User/insert_dir.php', true);
		request.onload = function(){
			if (request.readyState==4 && request.status==200) {
				let response=JSON.parse(request.responseText);
				//console.log(request);
				if (response.state) {
					(async () =>{
						await Swal.fire({
						  icon: 'success',
						  title: 'Agregada',
						  text: 'La dirección se ha agregado correctamente',
						  background: '#232323',
						  color: '#fff',
						  toast: true,
						  position: 'bottom-end',
						  timer: 3000,
						  timerProgressBar: true
						});
						window.location.reload();

					})();
				}else{
					Swal.fire({
						  icon: 'error',
						  title: 'Error',
						  text: (response.detail),
						  background: '#232323',
						  color: '#fff'
						});
				}
			}
		}
		request.send(fd);
    }

    function updateDir(){
    	let fd = new FormData();
		fd.append('nex', document.getElementById('nex').value);
		fd.append('nix', document.getElementById('nix').value);
		fd.append('cp', document.getElementById('cp').value);
		fd.append('estado', document.getElementById('estado').value);
		fd.append('colonia', document.getElementById('colonia').value);
		fd.append('calle', document.getElementById('calle').value);
		fd.append('municipio', document.getElementById('municipio').value);
		let request = new XMLHttpRequest();
		request.open('POST', 'api/User/update_dir.php', true);
		request.onload = function(){
			if (request.readyState==4 && request.status==200) {
				let response=JSON.parse(request.responseText);
				//console.log(request);
				if (response.state) {
					(async () =>{
						await Swal.fire({
						  icon: 'success',
						  title: 'Actualizada',
						  text: 'La dirección se ha actualizado correctamente',
						  background: '#232323',
						  color: '#fff',
						  toast: true,
						  position: 'bottom-end',
						  timer: 3000,
						  timerProgressBar: true
						});
						window.location.reload();

					})();
				}else{
					Swal.fire({
						  icon: 'error',
						  title: 'Error',
						  text: (response.detail),
						  background: '#232323',
						  color: '#fff'
						});
				}
			}
		}
		request.send(fd);
    }
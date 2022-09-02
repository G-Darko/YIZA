<?php 
	require('require/conexion.php');
	session_start();
	if (isset($_SESSION['id'])) {
		header('Location: dashboard.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style_iniS.css">
	<title>Iniciar Sesión</title>
</head>
<body>
	<div class="topBar">
		<span class="icon">
			<ion-icon name="storefront-outline"></ion-icon>
		</span>
		<span class="title" title="YIZA">YIZA</span>
		<div class="bordeT"></div>
	</div>
	<div class="contenedor">
		<h2>Iniciar Sesión</h2>
		<div class="form" >
			<div class="inputBx" title="Ingrsa tu usuario o tu correo">
				<input class="in" id="usu" type="text" name="usuario" required>
				<label for="usu">
					<span class="iconic">
						<ion-icon name="person-circle-outline"></ion-icon>
					</span>
					Usuario o Correo
				</label>
			</div>
			<div class="inputBx contra" title="Ingrsa tu contraseña">
				<input class="in" id="contra" type="password" name="contra" required autocomplete="off">
				<label for="contra">
					<span class="iconic">
						<ion-icon name="lock-closed-outline"></ion-icon>
					</span>
					Contraseña
				</label>
				<span class="pass">
					<span class="iconic btnPass" title="Mostrar Contraseña">
						<ion-icon name="eye-outline"></ion-icon>
					</span>
				</span>
			</div>
			<button onclick="iniciar()">
					<ion-icon name="key-outline"></ion-icon>&nbsp;
					Ingresar
			</button>
		</div>
	</div>
	<?php require 'require/footer.php'; ?>

	<script>
		let usuario = document.getElementById("usu");
        usuario.addEventListener("keydown", function (e) {
            if (e.keyCode === 13) { 
                document.getElementById('contra').focus();
            }
        });
        let contra_pass = document.getElementById("contra");
        contra_pass.addEventListener("keydown", function (e) {
            if (e.keyCode === 13) { 
                iniciar();
            }
        });

		let pass = document.querySelector('.pass');
		let btnPass = document.querySelector('.btnPass');
		let contra = document.querySelector('.contra');
		btnPass.onclick = function (){
			if(contra.firstElementChild.type === 'password'){
				contra.firstElementChild.type = 'text';
				this.firstElementChild.name = 'eye-off-outline';
				pass.firstElementChild.title = 'Ocultar Contraseña';
			}else{
				contra.firstElementChild.type = 'password';
				this.firstElementChild.name = 'eye-outline';
				pass.firstElementChild.title = 'Mostrar Contraseña';
			}
			
		}
		function iniciar(){
			let fd = new FormData();
			fd.append('usu', document.getElementById('usu').value);
			fd.append('contra', document.getElementById('contra').value);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/sesion.php', true);
			request.onload=function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					console.log(request);
					if (response.state) {
						/*(async () =>{
							await Swal.fire({
							  icon: 'success',
							  title: 'Actualizo',
							  text: 'La contraseña se actualizo correctamente',
							  background: '#232323',
							  color: '#fff'
							});
						})();*/
						//window.location.reload();
						window.location.href="dashboard.php"

					}else{
						//alert(response.detail);
						//Swal.fire(response.detail);
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
	</script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
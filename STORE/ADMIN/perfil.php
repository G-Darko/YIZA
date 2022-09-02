<?php 
	require('require/conexion.php');
	require 'require/session_start.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Administración | YIZA</title>
<?php require('require/nav_admin.php') ?>
			<!--  -->
			<div class="perfil">
				<div class="body">
					<div class="header">
						<h2> <ion-icon name="pencil-outline"></ion-icon> Editar Perfil </h2>
					</div>
					<div class="form">
						<button title="Guardar" class="btn" onclick="guardarPerfil()">
							<ion-icon name="save-outline"></ion-icon>
						</button>					
				<?php 
					$sql = "SELECT * from usuarios where id_usu = '$id_usu' ";
					$res=mysqli_query($conexion,$sql);
					while ($row=mysqli_fetch_assoc($res)){
				 ?>
						 <div class="inputBx">
							<input type="text" value="<?php echo $row['nombres']; ?>" required id="nombres">
							<label>
								<span class="a">*</span>
								Nombre(s)
							</label>
						 </div>
						 <div class="inputBx">
							<input type="text" value="<?php echo $row['ap1']; ?>" required id="ap1">
							<label>
								<span class="a">*</span>
								Primer Apellido
							</label>
						 </div>
						 <div class="inputBx">
							<input type="text" value="<?php echo $row['ap2']; ?>" required id="ap2">
							<label>
								Segundo Apellido
							</label>
						 </div>
						 <div class="inputBx">
							<input type="text" value="<?php echo $row['usuario']; ?>" required id="usuario">
							<label>
								<span class="a">*</span>
								Usuario
							</label>
						 </div>
						 <div class="inputBx">
							<input type="text" value="<?php echo $row['correo']; ?>" required id="correo">
							<label>
								<span class="a">*</span>
								Correo
							</label>
						 </div>
						 <div class="inputBx">
						 	<img class="imgP" id="imgP" src="<?php echo $row['img'];?>" alt="">

						 	<input class="file" type="file" id="img" required hidden accept="image/*" onchange="imagenChange('img', 'imgP', '<?php echo $row['img'];?>')">

							<label>Imagen</label>
						 </div>
						 <div class="btns">
						 	<button class="edit" onclick="guardarImagen()">
						 		<ion-icon name="cloud-upload-outline"></ion-icon>
						 	</button>
						 	<button class="delate" onclick="delateImg()">
						 		<ion-icon name="trash-outline"></ion-icon>
						 	</button>
						 	
						 </div>
						 <div class="inputBx">
							<input type="text" value="<?php echo $row['fechaAlta']; ?>" required id="fecha">
							<label>
								Fecha de Alta
							</label>
						 </div>
				<?php 
					}
				?>
						 <button class="contraUp" onclick="showModal('modal-Contra')">
						 	<ion-icon name="key-outline"></ion-icon>
						 	Cambiar contraseña
						 </button>
						 <div class="inputBx advertencia">
						 	 <label>
						 	 	<span class="a">*Nota:</span>
						 	 	La contraseña y la imagen de perfil se actualizan por separado de los otros datos
						 	 </label>	 
						 </div>
					</div>
				</div>
			</div>
			
			<div class="modal" id="modal-Contra" style="display: none;">
				<div class="container auto">
					<div class="header">
						<h2>
							<ion-icon name="lock-open-outline"></ion-icon>
							Cambiar contraseña
						</h2>
						<button title="Cerrar" class="btnClose" onclick="hideModal('modal-Contra')">
							<ion-icon name="close-circle-outline"></ion-icon>
						</button>
					</div>
					<div class="inputBx">
						<input type="password" id="pass" required>
						<label>
							<span class="a">*</span>
							Contraseña
						</label>
					</div>
					<div class="inputBx">
						<input type="password" id="npass" required>
						<label>
							<span class="a">*</span>
							Nueva contrseña
						</label>
					</div>
					<div class="inputBx">
						<input type="password" id="rnpass" required>
						<label>
							<span class="a">*</span>
							Confirmar nueva contrseña
						</label>
					</div>
					<button title="Guardar" class="savePass" onclick="guardarContra()">
						<ion-icon name="save-outline"></ion-icon>
						Guardar la nueva contraeña
					</button>
				</div>
			</div>

			<?php 
				require 'require/footer.php'; 
			?>
			</div>
		</div>
	</div>
	<?php require('require/scriptsJS.php') ?>
	<script>
		let imgP = document.querySelector('.imgP');
		let file = document.querySelector('.file');
		let btns = document.querySelector('.btns');
		
		
		imgP.onclick = function(){
			subir('img');
			btns.classList.add('show')
		}


		
		function delateImg(){
			Swal.fire({
			  title: '¿Seguro de eliminar?',
			  text: "Esto no se podra revertir",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Si, eliminar',
			  cancelButtonText: 'Cancelar',
			  background: mainC,
			  color: negro1
			}).then((result) => {
			  	if (result.isConfirmed) {
				    let fd = new FormData();
					fd.append('img', document.getElementById('img').files[0]);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Perfil/delateImgP.php', true);
					request.onload=function(){
						if (request.readyState==4 && request.status==200) {
							let response=JSON.parse(request.responseText);
							//console.log(request);
							if (response.state) {
								/*(async () =>{
									await Swal.fire({
									  icon: 'success',
									  title: 'Eliminado',
									  text: 'La imagen se ha eliminado',
									  background: mainC,
									  color: negro1
									});
								})();*/
									window.location.reload();

							}else{
								//alert(response.detail);
								//Swal.fire(response.detail);
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
		function guardarImagen(){
			let fd = new FormData();
			fd.append('img', document.getElementById('img').files[0]);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/Perfil/changeImgP.php', true);
			request.onload=function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					if (response.state) {
						(async () =>{
							await Swal.fire({
							  icon: 'success',
							  title: '',
							  text: 'Imagen subida correctamente',
							  background: mainC,
							  color: negro1
							});
							window.location.reload();
						})();

					}else{
						//alert(response.detail);
						//Swal.fire(response.detail);
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

		function guardarPerfil(){
			Swal.fire({
			  title: 'Confirmar',
			  text: "Se van a actualizar los datos",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Actualizar',
			  cancelButtonText: 'Cancelar',
			  background: mainC,
			  color: negro1
			}).then((result) => {
			  	if (result.isConfirmed) {
					let fd = new FormData();
					fd.append('nombres', document.getElementById('nombres').value);
					fd.append('ap1', document.getElementById('ap1').value);
					fd.append('ap2', document.getElementById('ap2').value);
					fd.append('usuario', document.getElementById('usuario').value);
					fd.append('correo', document.getElementById('correo').value);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Perfil/editPerfil.php', true);
					request.onload=function(){
						if (request.readyState==4 && request.status==200) {
							let response=JSON.parse(request.responseText);
							//console.log(request);
							if (response.state) {
								(async () =>{
									await Swal.fire({
									  icon: 'success',
									  title: 'Actualizo',
									  text: 'Lo datos se actualizaron correctamente',
									  background: mainC,
									  color: negro1
									});
									window.location.reload();

								})();
							}else{
								//alert(response.detail);
								//Swal.fire(response.detail);
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
		function guardarContra(){
			let fd = new FormData();
			fd.append('pass', document.getElementById('pass').value);
			fd.append('npass', document.getElementById('npass').value);
			fd.append('rnpass', document.getElementById('rnpass').value);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/Perfil/changeContra.php', true);
			request.onload=function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					if (response.state) {
						(async () =>{
							await Swal.fire({
							  icon: 'success',
							  title: 'Actualizo',
							  text: 'La contraseña se actualizo correctamente',
							  background: mainC,
							  color: negro1
							});
							window.location.reload();

						})();
					}else{
						//alert(response.detail);
						//Swal.fire(response.detail);
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
	</script>

</body>
</html>
<?php 
	require('require/conexion.php');
	require 'require/session_start.php';
	
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Marcas | YIZA</title>
<?php require('require/nav_admin.php') ?>

				<div class="caja">
					<div class="container">
						<div class="header">
							<h2>
								<ion-icon name="list-outline"></ion-icon>	
								Marcas 
							</h2>
								<div class="plus" title="Agregar" onclick="showModal('modal-NMar')">
									<ion-icon name="add-outline"></ion-icon>
								</div>
						</div>
						<table>
							<thead>
								<tr>
									<td>Nombre de la Marca</td>
									<td>Imagen</td>
									<td>Opciones</td>
								</tr>
							</thead>
							<tbody>
								<?php 

								$sqlT = mysqli_query($conexion, "SELECT COUNT(*) as total FROM marcas");
								$resT = mysqli_fetch_assoc($sqlT);
								$total = $resT['total'];

								$xPage = $iAdmin;
								if (empty($_GET['page'])) {
									$page = 1;
								}else{
									$page = $_GET['page'];
								}

								 
								$desde = ($page-1) * $xPage;
								$tPags = ceil($total / $xPage);

								if ($page <= 0 || $_GET['page'] <= 0 || ($page > $tPags && $page != 1) || ($_GET['page'] > $tPags && $_GET['page'] != 1) ) {
								 	header("Location: marcas.php?page=1");
								}
								if ($total == 0) {
									echo "
									<tr>
										<td colspan='3'>
											No hay marcas, puedes agregar desde el icono &nbsp;

											<ion-icon style='font-size: 1.3em; transform: translateY(7px); background: var(--azul); border-radius: 5px; color: var(--blanco); width: 30px; height: 30px;' name='add-outline'></ion-icon>
										</td>
									</tr>
									";
								}


									$sql= "SELECT * from marcas order by nombre limit $desde, $xPage";
									$res=mysqli_query($conexion,$sql);
									while ($row=mysqli_fetch_assoc($res)){
								?>
								<tr>
									<td title="<?php echo $row['nombre'];?>"><?php 
										echo $row['nombre']; 
									?></td>
									<td>
										<img src="<?php echo $row['img'];?>" width="200px" alt="">
									<td>
									<td>
										<div class="btns2">
											<button class="edit" title="Editar" onclick="editMar(<?php echo $row['id_mar'];?>)">
										 		<ion-icon name="pencil-outline"></ion-icon>
										 	</button>
										 	<button class="delate" title="Eliminar" onclick="delateMar(<?php echo $row['id_mar'];?>)">
										 		<ion-icon name="trash-outline"></ion-icon>
										 	</button>
										</div>
									</td>
								</tr>
								<?php 
									} 
								?>
								<tr>
									<td colspan="3">
										<label>
									 	 	<span class="a">*Nota:</span>
									 	 	Se necesitan minimo dos marcas para el slider
									 	</label>	
									</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="paginador">
						<ul>
					<?php 
						if ($page != 1) {
					?>
							<li><a href="?page=1">|<</a></li>
							<li><a href="?page=<?php echo $page-1;?>"><<</a></li>
					<?php 
						}
							if ($tPags <= 5) {
								for ($i=1; $i <= $tPags; $i++) { 
									if ($i == $page) {
										echo '<li class="pageSelect">'.$i.'</li>';
									}else{
										echo '<li><a href="?page='.$i.'">'.$i.'</a></li>';
									}
								}
							}else{
								for ($i = max(1, min($page, $tPags - 5)); $i < max(6, min($page + 6, $tPags + 1)); $i++ ) { 
									if ($i == $page) {
										echo '<li class="pageSelect">'.$i.'</li>';
									}else{
										echo '<li><a href="?page='.$i.'">'.$i.'</a></li>';
									}
								}
							}
						if ($page != $tPags && $tPags > 0) {
					?>
							<li><a href="?page=<?php echo $page+1;?>">>></a></li>
							<li><a href="?page=<?php echo $tPags;?>">>|</a></li>
					<?php 
						}
					?>
						</ul>
					</div>
					
				</div>

				<div class="modal" id="modal-NMar" style="display: none;">
					<div class="container auto">
						<div class="header">
							<h2>
								<ion-icon name="add-outline"></ion-icon>
								Nueva Marca
							</h2>
							<button title="Cerrar" class="btnClose" onclick="hideModal('modal-NMar')">
								<ion-icon name="close-circle-outline"></ion-icon>
							</button>
						</div>
						<div class="inputBx">
							<input type="text" id="nombre" required>
							<label>
								<span class="a">*</span>
								Nombre
							</label>
						</div>
						<div class="inputBx">
							<img class="cuadro" id="cuadro" src="img/logo3.png" alt="Imagen predeterminada de Marcas" onclick="subir('img')">
							<input type="file" id="img" required onchange="imagenChange('img', 'cuadro', 'img/logo3.png')" hidden>
							<label>
								Imagen
							</label>
						</div>

						<button title="Agregar" class="savePass" onclick="agregarMar()">
							<ion-icon name="bag-add-outline"></ion-icon>
							Agregar
						</button>
					</div>
				</div>

				<div class="modal" id="modal-Edit" style="display: none;">
					<div class="container auto">
						<div class="header">
							<h2>
								<ion-icon name="pencil-outline"></ion-icon>
								Editar Marca
							</h2>
							<button title="Cerrar" class="btnClose" onclick="hideModal('modal-Edit')">
								<ion-icon name="close-circle-outline"></ion-icon>
							</button>
						</div>

						<div class="inputBx">
							<input type="hidden" value="" id="id_mar">
							<input type="text" id="nombre-e" required>
							<label>
								<span class="a">*</span>
								Nombre
							</label>
						</div>
						<div class="inputBx">
							<img id="img-e" class="cuadro" src="" onclick="subir('inputImg')">
							<input type="file" id="inputImg" required hidden onchange="imagenChange('inputImg', 'img-e', document.getElementById('img-e').src)">
							<label>
								Imagen
							</label>
						</div>

						<button title="Actualizar" class="savePass" onclick="updateMar()">
							<ion-icon name="save-outline"></ion-icon>
							Guardar Cambios
						</button>
					</div>
				</div>

			<?php 
				require 'require/footer.php'; 
			?>
			</div>
		</div>
	</div>
	<?php require('require/scriptsJS.php') ?>}
	<script>
		function agregarMar(){
			let fd = new FormData();
			fd.append('nombre', document.getElementById('nombre').value);
			fd.append('img', document.getElementById('img').files[0]);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/Marcas/agregarMar.php', true);
			request.onload=function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					if (response.state) {
						(async () =>{
							await Swal.fire({
							  icon: 'success',
							  title: 'Agregado',
							  text: 'Marca agregada correctamente',
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
		function editMar(id_mar){
			let fd = new FormData();
			fd.append('id_mar', id_mar);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/Marcas/get_Mar.php', true);
			request.onload = function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					document.getElementById("id_mar").value=id_mar;
					document.getElementById('nombre-e').value=response.mar.nombre;
					document.getElementById('img-e').src=response.mar.img;
					showModal('modal-Edit');
				}
			}
			request.send(fd);			
		}
		function delateMar(id_mar){
			Swal.fire({
			  title: '¿Seguro de eliminar?',
			  text: "Esto no se podra revertir, además eliminara las dependencias",
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
					fd.append('id_mar',id_mar);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Marcas/delateMar.php', true);
					request.onload=function(){
						if (request.readyState==4 && request.status==200) {
							let response=JSON.parse(request.responseText);
							//console.log(request);
							if (response.state) {
								(async () =>{
									await Swal.fire({
									  icon: 'success',
									  title: 'Eliminado',
									  text: 'La marca se ha eliminado',
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
		function updateMar(){
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
  					fd.append('id_mar',document.getElementById('id_mar').value);
					fd.append('nombre-e', document.getElementById('nombre-e').value);
					fd.append('inputImg', document.getElementById('inputImg').files[0]);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Marcas/editMar.php', true);
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
	</script>
</body>
</html>

<!-- <?php
	date_default_timezone_set ('America/Mexico_City');
	echo strftime(date('Y')."-".date('m')."-".date('d')) ;
?> -->
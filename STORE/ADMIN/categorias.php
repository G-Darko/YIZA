<?php 
	require('require/conexion.php');
	require 'require/session_start.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Categorías | YIZA</title>
<?php require('require/nav_admin.php') ?>

				<div class="caja">
					<div class="container">
						<div class="header">
							<h2>
								<ion-icon name="list-outline"></ion-icon>	
								Categorías 
							</h2>
								<div class="plus" title="Agregar" onclick="showModal('modal-NCat')">
									<ion-icon name="add-outline"></ion-icon>
								</div>
						</div>
						<table>
							<thead>
								<tr>
									<td>Nombre de la Categoría <ion-icon style="font-size: 1.3em; transform: translateY(5px);" name="arrow-forward-outline"></ion-icon> Subcategoría</td>
									<td>Estado</td>
									<td>Opciones</td>
								</tr>
							</thead>
							<tbody>
								<?php 

								$sqlT = mysqli_query($conexion, "SELECT COUNT(*) as total FROM categorias");
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
								 	header("Location: categorias.php?page=1");
								}
								if ($total == 0) {
									echo "
									<tr>
										<td colspan='3'>
											No hay categorías, puedes agregar desde el icono &nbsp;

											<ion-icon style='font-size: 1.3em; transform: translateY(7px); background: var(--azul); border-radius: 5px; color: var(--blanco); width: 30px; height: 30px;' name='add-outline'></ion-icon>
										</td>
									</tr>
									";
								}


									$sql= "SELECT * from categorias order by nombre limit $desde, $xPage";
									$res=mysqli_query($conexion,$sql);
									while ($row=mysqli_fetch_assoc($res)){
										$id = $row['id_cat'];
											if ($row['id_statusCat'] == 1) {
												$status = "
													<span class='status delivered'>
														Habilitado
													</span>";
											}else{
												$status = "
													<span class='status return'>
														Deshabilitado
													</span>";
											}
								?>
								<tr>
									<td title="<?php echo $row['nombre'];?>"><?php 
										$sqlPadre = "SELECT * FROM cPadre where id_cat = $id";
										$resP=mysqli_query($conexion,$sqlPadre);
										while ($rowP=mysqli_fetch_assoc($resP)){
											$id_cat2 = $rowP['id_cat'];
											$id_padre2 = $rowP['id_padre'];
											if ($id_cat2 == $id_padre2) {
												$padre = "";
												echo $padre;			
											}else{
												$sql2= "SELECT nombre from categorias where id_cat = $id_padre2";
												$res2=mysqli_query($conexion,$sql2);
												while ($row2=mysqli_fetch_assoc($res2)){
													$padre = $row2['nombre']." <ion-icon style='font-size: 1.3em; transform: translateY(5px);' name='arrow-forward-outline'></ion-icon> ";
													echo $padre;
												}
											}
												
										}
										echo $row['nombre']; 
									?></td>
									<td><?php echo $status; ?></td>
									<td>
										<div class="btns2">
											<button class="edit" title="Editar" onclick="editCat(<?php echo $row['id_cat'];?>)">
										 		<ion-icon name="pencil-outline"></ion-icon>
										 	</button>
										 	<button class="delate" title="Eliminar" onclick="delateCat(<?php echo $row['id_cat'];?>)">
										 		<ion-icon name="trash-outline"></ion-icon>
										 	</button>
										</div>
									</td>
								</tr>
								<?php 
									} 
								?>
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

				<div class="modal" id="modal-NCat" style="display: none;">
					<div class="container">
						<div class="header">
							<h2>
								<ion-icon name="add-outline"></ion-icon>
								Nueva Categoria
							</h2>
							<button title="Cerrar" class="btnClose" onclick="hideModal('modal-NCat')">
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
							<textarea id="des"  required></textarea>
							<label>
								Descripción
							</label>
						</div>
						<div class="inputBx">
							<input type="text" id="tMeta" required>
							<label>
								<span class="a">*</span>
								Titulo Meta Tag
							</label>
						</div>
						<div class="inputBx">
							<textarea id="desMeta"  required></textarea>
							<label>
								Descripción Meta Tag
							</label>
						</div>

						<div class="inputBx">
							<textarea id="clave"  required></textarea>
							<label>
								Palabras Clave Meta Tag
							</label>
						</div>


						<div class="inputBx">
							<?php require 'require/statusAll.php'; ?>
							<label>
								Estado
							</label>
						</div>

						<div class="inputBx">
							<select id="padre" required>
								<option value="0" selected="">Ninguno</option>
								<?php 
									$sqlPadre = "SELECT * FROM cPadre";
									$resP=mysqli_query($conexion,$sqlPadre);
									while ($rowP=mysqli_fetch_assoc($resP)){
										$id_cat = $rowP['id_cat'];
										$id_padre = $rowP['id_padre'];
										//echo $id_padre." ".$id_cat."-";
										if ($id_cat == $id_padre) {

											$sql= "SELECT * from categorias where id_cat = $id_padre AND id_statusCat = 1 order by nombre";
											$res=mysqli_query($conexion,$sql);
											while ($row=mysqli_fetch_assoc($res)){
										
								?>
								<option value="<?php echo $row['id_cat']; ?>"><?php echo $row['nombre'];?></option>
							<?php 
											}
										}
									} 
							?>
							</select>
							<label>
								Padre
							</label>
						</div>


						<button title="Agregar" class="savePass" onclick="agregarCat()">
							<ion-icon name="bag-add-outline"></ion-icon>
							Agregar
						</button>
					</div>
				</div>

				<div class="modal" id="modal-Edit" style="display: none;">
					<div class="container editM">
						<div class="header">
							<h2>
								<ion-icon name="pencil-outline"></ion-icon>
								Editar Categoria
							</h2>
							<button title="Cerrar" class="btnClose" onclick="hideModal('modal-Edit')">
								<ion-icon name="close-circle-outline"></ion-icon>
							</button>
						</div>
						<div class="inputBx">
							<input type="text" id="nombre-e" required>
							<label>
								<span class="a">*</span>
								Nombre
							</label>
						</div>
						<div class="inputBx">
							<textarea id="des-e"  required></textarea>
							<label>
								Descripción
							</label>
						</div>
						<div class="inputBx">
							<input type="text" id="tMeta-e" required>
							<label>
								<span class="a">*</span>
								Titulo Meta Tag
							</label>
						</div>
						<div class="inputBx">
							<textarea id="desMeta-e"  required></textarea>
							<label>
								Descripción Meta Tag
							</label>
						</div>

						<div class="inputBx">
							<textarea id="clave-e"  required></textarea>
							<label>
								Palabras Clave Meta Tag
							</label>
						</div>


						<div class="inputBx">
							<select id="status-e" required>
								<?php 
									$sql= "SELECT * from statusAll";
									$res=mysqli_query($conexion,$sql);
									while ($row=mysqli_fetch_assoc($res)){
								?>
								<option value="<?php echo $row['id_status'];?>"><?php echo $row['status'];?></option>
							<?php } ?>
							</select>
							<label>
								Estado
							</label>
						</div>

						<div class="inputBx">
							<input type="hidden" value="" id="id_cat">
							<select id="padre-e" required>
								<option value="0" selected>Ninguno</option>
								<?php 
									$sqlPadre = "SELECT * FROM cPadre";
									$resP=mysqli_query($conexion,$sqlPadre);
									while ($rowP=mysqli_fetch_assoc($resP)){
										$id_cat = $rowP['id_cat'];
										$id_padre = $rowP['id_padre'];
										//echo $id_padre." ".$id_cat."-";
										if ($id_cat == $id_padre) {

											$sql= "SELECT * from categorias where id_cat = $id_padre AND id_statusCat = 1 order by nombre";
											$res=mysqli_query($conexion,$sql);
											while ($row=mysqli_fetch_assoc($res)){
										
								?>
								<option value="<?php echo $row['id_cat'];?>"><?php echo $row['nombre'];?></option>
							<?php 
											}
										}
									} 
							?>
							</select>
							<label>
								Padre
							</label>
						</div>


						<button title="Actualizar" class="savePass" onclick="updateCat()">
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
		function updateCat(){
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
  					fd.append('id_cat',document.getElementById('id_cat').value);
					fd.append('nombre-e', document.getElementById('nombre-e').value);
					fd.append('des-e', document.getElementById('des-e').value);
					fd.append('tMeta-e', document.getElementById('tMeta-e').value);
					fd.append('desMeta-e', document.getElementById('desMeta-e').value);
					fd.append('clave-e', document.getElementById('clave-e').value);
					fd.append('status-e', document.getElementById('status-e').value);
					fd.append('padre-e', document.getElementById('padre-e').value);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Categorias/editCat.php', true);
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
		function delateCat(id_cat){
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
					fd.append('id_cat',id_cat);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Categorias/delateCat.php', true);
					request.onload=function(){
						if (request.readyState==4 && request.status==200) {
							let response=JSON.parse(request.responseText);
							//console.log(request);
							if (response.state) {
								(async () =>{
									await Swal.fire({
									  icon: 'success',
									  title: 'Eliminado',
									  text: 'La categoría se ha eliminado',
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
		function agregarCat(){
			let fd = new FormData();
			fd.append('nombre', document.getElementById('nombre').value);
			fd.append('des', document.getElementById('des').value);
			fd.append('tMeta', document.getElementById('tMeta').value);
			fd.append('desMeta', document.getElementById('desMeta').value);
			fd.append('clave', document.getElementById('clave').value);
			fd.append('status', document.getElementById('status').value);
			fd.append('padre', document.getElementById('padre').value);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/Categorias/agregarCat.php', true);
			request.onload=function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					if (response.state) {
						(async () =>{
							await Swal.fire({
							  icon: 'success',
							  title: 'Agregado',
							  text: 'La categoria se agregó correctamente',
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

		//Abre un modal con todos los datos
		function editCat(id_cat){
			let fd = new FormData();
			fd.append('id_cat', id_cat);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/Categorias/get_Cat.php', true);
			request.onload = function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					document.getElementById("id_cat").value=id_cat;
					document.getElementById('nombre-e').value=response.cat.nombre;
					document.getElementById('des-e').value=response.cat.des;
					document.getElementById('tMeta-e').value=response.cat.tMeta;
					document.getElementById('desMeta-e').value=response.cat.desMeta;
					document.getElementById('clave-e').value=response.cat.clave;
					document.getElementById('status-e').value=response.cat.status;
					document.getElementById('padre-e').value=response.cat.padre;
					showModal('modal-Edit');
				}
			}
			request.send(fd);			
		}

	</script>
</body>
</html>

<!-- <?php
	date_default_timezone_set ('America/Mexico_City');
	echo strftime(date('Y')."-".date('m')."-".date('d')) ;
?> -->
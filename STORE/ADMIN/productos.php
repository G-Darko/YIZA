<?php 
	require('require/conexion.php');
	require 'require/session_start.php';
	
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Productos | YIZA</title>
<?php require('require/nav_admin.php') ?>
				
				<div class="caja">
					<div class="container">
						<div class="header">
							<h2>
								<ion-icon name="list-outline"></ion-icon>	
								Productos 
							</h2>
								<div class="plus" title="Agregar" onclick="showModal('modal-NProd')">
									<ion-icon name="add-outline"></ion-icon>
								</div>
						</div>
						<table>
							<thead>
								<tr>
									<td>Imagen</td>
									<td>Nombre del Producto</td>
									<td>Modelo</td>
									<td>Precio</td>
									<td>Stock</td>
									<td>Status</td>
									<td>Opciones</td>
								</tr>
							</thead>
							<tbody>
								<?php 

								$sqlT = mysqli_query($conexion, "SELECT COUNT(*) as total FROM productos");
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
								 	header("Location: productos.php?page=1");
								}
								if ($total == 0) {
									echo "
									<tr>
										<td colspan='7'>
											No hay productos, puedes agregar desde el icono &nbsp;

											<ion-icon style='font-size: 1.3em; transform: translateY(7px); background: var(--azul); border-radius: 5px; color: var(--blanco); width: 30px; height: 30px;' name='add-outline'></ion-icon>
										</td>
									</tr>
									";
								}


									$sql= "SELECT * from productos order by nombre limit $desde, $xPage";
									$res=mysqli_query($conexion,$sql);
									while ($row=mysqli_fetch_assoc($res)){
								?>
								<tr>
									<td>
										<img src="<?php echo $row['img'];?>" width="40px" alt="">
									</td>
									<td title="<?php echo $row['nombre'];?>"><?php 
											echo $row['nombre'];
										?>
									</td>
									<td><?php 
											echo $row['modelo'];
										?>
									</td>
									<td><?php 
											echo $row['precio'];
										?>
									</td>
									<td><?php 
											echo $row['stock'];
										?>
									</td>
									<td>
										<?php 
											if ($row['id_statusProd'] == 1) {
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
											echo $status;
										?>
									</td>
									<td>
										<div class="btns2">
											<button class="edit" title="Editar" onclick="editProd(<?php echo $row['id_prod'];?>)">
										 		<ion-icon name="pencil-outline"></ion-icon>
										 	</button>
										 	<button class="delate" title="Eliminar" onclick="delateProd(<?php echo $row['id_prod'];?>)">
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

				<div class="modal" id="modal-NProd" style="display: none;">
					<div class="container editM">
						<div class="header">
							<h2>
								<ion-icon name="add-outline"></ion-icon>
								Nuevo Producto
							</h2>
							<button title="Cerrar" class="btnClose" onclick="hideModal('modal-NProd')">
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
							<input type="text" id="modelo" required>
							<label>
								<span class="a">*</span>
								Modelo
							</label>
						</div>
						<div class="inputBx">
							<input type="text" id="sku" required>
							<label>
								SKU
							</label>
						</div>
						<div class="inputBx">
							<input type="number" id="precio" required>
							<label>
								Precio
							</label>
						</div>
						<div class="inputBx">
							<input type="number" id="stock" required>
							<label>
								Stock
							</label>
						</div>

						<div class="inputBx">
							<?php require 'require/statusAll.php'; ?>
							<label>
								Estado
							</label>
						</div>
						<div class="inputBx">
							<select id="id_mar" required>
								<?php 
									$sql= "SELECT * from marcas";
									$res=mysqli_query($conexion,$sql);
									while ($row=mysqli_fetch_assoc($res)){
								?>
								<option value="<?php echo $row['id_mar']; ?>"><?php echo $row['nombre']; ?></option>
							<?php } ?>
							</select>
							<label>
								Marca
							</label>
						</div>
						<div class="inputBx">
							<select id="id_cat" required>
								<?php 
									$sql= "SELECT * from categorias";
									$res=mysqli_query($conexion,$sql);
									while ($row=mysqli_fetch_assoc($res)){
								?>
								<option value="<?php echo $row['id_cat'];?>"><?php echo $row['nombre'];?></option>
							<?php } ?>
							</select>
							<label>
								Categoría
							</label>
						</div>
						<div class="inputBx">
							<img class="cuadro" id="cuadro" src="img/logo.jpg" alt="Imagen predeterminada de Marcas" onclick="subir('img')">
							<input type="file" id="img" required required hidden onchange="imagenChange('img', 'cuadro', 'img/logo.jpg')">
							<label>
								Imagen
							</label>
						</div>

						<button title="Agregar" class="savePass" onclick="agregarProd()">
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
								Editar Producto
							</h2>
							<button title="Cerrar" class="btnClose" onclick="hideModal('modal-Edit')">
								<ion-icon name="close-circle-outline"></ion-icon>
							</button>
						</div>

						<div class="inputBx">
							<input type="hidden" value="" id="id_prod">
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
							<input type="text" id="modelo-e" required>
							<label>
								<span class="a">*</span>
								Modelo
							</label>
						</div>
						<div class="inputBx">
							<input type="text" id="sku-e" required>
							<label>
								SKU
							</label>
						</div>
						<div class="inputBx">
							<input type="number" id="precio-e" required>
							<label>
								Precio
							</label>
						</div>
						<div class="inputBx">
							<input type="number" id="stock-e" required>
							<label>
								Stock
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
							<select id="id_mar-e" required>
								<?php 
									$sql= "SELECT * from marcas";
									$res=mysqli_query($conexion,$sql);
									while ($row=mysqli_fetch_assoc($res)){
								?>
								<option value="<?php echo $row['id_mar'];?>"><?php echo $row['nombre'];?></option>
							<?php } ?>
							</select>
							<label>
								Marca
							</label>
						</div>
						<div class="inputBx">
							<select id="id_cat-e" required>
								<?php 
									$sql= "SELECT * from categorias";
									$res=mysqli_query($conexion,$sql);
									while ($row=mysqli_fetch_assoc($res)){
								?>
								<option value="<?php echo $row['id_cat'];?>"><?php echo $row['nombre'];?></option>
							<?php } ?>
							</select>
							<label>
								Categoría
							</label>
						</div>


						<div class="inputBx">
							<img id="img-e" class="cuadro" src="" onclick="subir('inputImg')">
							<input type="file" id="inputImg" required hidden onchange="imagenChange('inputImg', 'img-e', document.getElementById('img-e').src)">
							<label>
								Imagen
							</label>
						</div>

						<button title="Actualizar" class="savePass" onclick="updateProd()">
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
		function agregarProd(){
			let fd = new FormData();
			fd.append('nombre', document.getElementById('nombre').value);
			fd.append('des', document.getElementById('des').value);
			fd.append('tMeta', document.getElementById('tMeta').value);
			fd.append('desMeta', document.getElementById('desMeta').value);
			fd.append('clave', document.getElementById('clave').value);
			fd.append('modelo', document.getElementById('modelo').value);
			fd.append('sku', document.getElementById('sku').value);
			fd.append('precio', document.getElementById('precio').value);
			fd.append('stock', document.getElementById('stock').value);
			fd.append('status', document.getElementById('status').value);
			fd.append('id_mar', document.getElementById('id_mar').value);
			fd.append('id_cat', document.getElementById('id_cat').value);
			fd.append('img', document.getElementById('img').files[0]);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/Productos/agregarProd.php', true);
			request.onload=function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					if (response.state) {
						(async () =>{
							await Swal.fire({
							  icon: 'success',
							  title: 'Agregado',
							  text: 'Producto agregado correctamente',
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
		function editProd(id_prod){
			let fd = new FormData();
			fd.append('id_prod', id_prod);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/Productos/get_Prod.php', true);
			request.onload = function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					document.getElementById("id_prod").value=id_prod;
					document.getElementById('nombre-e').value=response.prod.nombre;
					document.getElementById('des-e').value=response.prod.des;
					document.getElementById('tMeta-e').value=response.prod.tMeta;
					document.getElementById('desMeta-e').value=response.prod.desMeta;
					document.getElementById('clave-e').value=response.prod.clave;
					document.getElementById('modelo-e').value=response.prod.modelo;
					document.getElementById('sku-e').value=response.prod.sku;
					document.getElementById('precio-e').value=response.prod.precio;
					document.getElementById('stock-e').value=response.prod.stock;
					document.getElementById('status-e').value=response.prod.status;
					document.getElementById('id_mar-e').value=response.prod.id_mar;
					document.getElementById('id_cat-e').value=response.prod.id_cat;
					document.getElementById('img-e').src=response.prod.img;
					showModal('modal-Edit');
				}
			}
			request.send(fd);			
		}
		function delateProd(id_prod){
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
					fd.append('id_prod',id_prod);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Productos/delateProd.php', true);
					request.onload=function(){
						if (request.readyState==4 && request.status==200) {
							let response=JSON.parse(request.responseText);
							//console.log(request);
							if (response.state) {
								(async () =>{
									await Swal.fire({
									  icon: 'success',
									  title: 'Eliminado',
									  text: 'El producto se ha eliminado',
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
		function updateProd(){
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
  					fd.append('id_prod',document.getElementById('id_prod').value);
					fd.append('nombre-e', document.getElementById('nombre-e').value);
					fd.append('des-e', document.getElementById('des-e').value);
					fd.append('tMeta-e', document.getElementById('tMeta-e').value);
					fd.append('desMeta-e', document.getElementById('desMeta-e').value);
					fd.append('clave-e', document.getElementById('clave-e').value);
					fd.append('modelo-e', document.getElementById('modelo-e').value);
					fd.append('sku-e', document.getElementById('sku-e').value);
					fd.append('precio-e', document.getElementById('precio-e').value);
					fd.append('stock-e', document.getElementById('stock-e').value);
					fd.append('status-e', document.getElementById('status-e').value);
					fd.append('id_mar-e', document.getElementById('id_mar-e').value);
					fd.append('id_cat-e', document.getElementById('id_cat-e').value);
					fd.append('inputImg', document.getElementById('inputImg').files[0]);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Productos/editProd.php', true);
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
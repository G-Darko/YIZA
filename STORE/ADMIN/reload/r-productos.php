<?php 
	require '../require/conexion.php';
	require '../require/_config.php';
?>
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

								$page = $_POST['page'];
								 
								
								$tPags = ceil($total / $xPage);
								
								if ($page <= 0 || ($page > $tPags && $page != 1)) {
									//header("Location: marcas.php?page=1");
									$page = $tPags;
								}
								
								$desde = ($page-1) * $xPage;

								
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

					<div class="paginador" id="pag">
						<ul>
						<?php 
							if ($page != 1) {
						?>
							<li><a onclick="(paginador(1, 'reload/r-productos.php'))">|<</a></li>
							<li><a onclick="(paginador(<?php echo $page-1?>, 'reload/r-productos.php'))"><<</a></li>
						<?php 
							}
							if ($tPags <= 5) {
								for ($i=1; $i <= $tPags; $i++) { 
									if ($i == $page) {
										echo '<li class="pageSelect">'.$i.'</li>';
									}else{
						?>
										
										<li>
											<a onclick="(paginador(<?php echo $i?>, 'reload/r-productos.php'))"><?php echo $i?>
											</a>
										</li>'
						<?php
									}
								}
							}else{
								for ($i = max(1, min($page, $tPags - 5)); $i < max(6, min($page + 6, $tPags + 1)); $i++ ) { 
									if ($i == $page) {
										echo '<li class="pageSelect">'.$i.'</li>';
									}else{
						?>
										
										<li>
											<a onclick="(paginador(<?php echo $i?>, 'reload/r-productos.php'))"><?php echo $i?>
											</a>
										</li>'
						<?php
									}
								}
							}
						if ($page != $tPags && $tPags > 0) {
						?>
							<li><a onclick="(paginador(<?php echo $page+1?>, 'reload/r-productos.php'))">>></a></li>
							<li><a onclick="(paginador(<?php echo $tPags?>, 'reload/r-productos.php'))">>|</a></li>
						<?php 
						}
						?>
						</ul>
					</div>
					
					<input type="text" id="page" value="<?php echo $page?>" hidden>

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
							<?php require '../require/statusAll.php'; ?>
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
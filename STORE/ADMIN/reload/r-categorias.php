<?php 
	require '../require/conexion.php';
	require '../require/_config.php';
?>
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

					<div class="paginador" id="pag">
						<ul>
						<?php 
							if ($page != 1) {
						?>
							<li><a onclick="(paginador(1, 'reload/r-categorias.php'))">|<</a></li>
							<li><a onclick="(paginador(<?php echo $page-1?>, 'reload/r-categorias.php'))"><<</a></li>
						<?php 
							}
							if ($tPags <= 5) {
								for ($i=1; $i <= $tPags; $i++) { 
									if ($i == $page) {
										echo '<li class="pageSelect">'.$i.'</li>';
									}else{
						?>
										
										<li>
											<a onclick="(paginador(<?php echo $i?>, 'reload/r-categorias.php'))"><?php echo $i?>
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
											<a onclick="(paginador(<?php echo $i?>, 'reload/r-categorias.php'))"><?php echo $i?>
											</a>
										</li>'
						<?php
									}
								}
							}
						if ($page != $tPags && $tPags > 0) {
						?>
							<li><a onclick="(paginador(<?php echo $page+1?>, 'reload/r-categorias.php'))">>></a></li>
							<li><a onclick="(paginador(<?php echo $tPags?>, 'reload/r-categorias.php'))">>|</a></li>
						<?php 
						}
						?>
						</ul>
					</div>
					
					<input type="text" id="page" value="<?php echo $page?>" hidden>
					
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
							<?php require '../require/statusAll.php'; ?>
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
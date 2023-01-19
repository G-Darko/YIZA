<?php 
	require '../require/conexion.php';
	require '../require/_config.php';
?>

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

					<div class="paginador" id="pag">
						<ul>
						<?php 
							if ($page != 1) {
						?>
							<li><a onclick="(paginador(1, 'reload/r-marcas.php'))">|<</a></li>
							<li><a onclick="(paginador(<?php echo $page-1?>, 'reload/r-marcas.php'))"><<</a></li>
						<?php 
							}
							if ($tPags <= 5) {
								for ($i=1; $i <= $tPags; $i++) { 
									if ($i == $page) {
										echo '<li class="pageSelect">'.$i.'</li>';
									}else{
						?>
										
										<li>
											<a onclick="(paginador(<?php echo $i?>, 'reload/r-marcas.php'))"><?php echo $i?>
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
											<a onclick="(paginador(<?php echo $i?>, 'reload/r-marcas.php'))"><?php echo $i?>
											</a>
										</li>'
						<?php
									}
								}
							}
						if ($page != $tPags && $tPags > 0) {
						?>
							<li><a onclick="(paginador(<?php echo $page+1?>, 'reload/r-marcas.php'))">>></a></li>
							<li><a onclick="(paginador(<?php echo $tPags?>, 'reload/r-marcas.php'))">>|</a></li>
						<?php 
						}
						?>
						</ul>
					</div>
					
					<input type="text" id="page" value="<?php echo $page?>" hidden>
				</div>


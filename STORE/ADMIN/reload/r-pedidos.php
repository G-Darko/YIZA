<?php 
	require '../require/conexion.php';
	require '../require/_config.php';
?>
				<div class="caja">
					<div class="container">
						<div class="header">
							<h2>
								<ion-icon name="list-outline"></ion-icon>	
								Pedidos 
							</h2>
						</div>
						<table>
							<thead>
								<tr>
									<td>Imagen</td>
									<td>Nombre del Producto</td>
									<td>Pago</td>
									<td>Cantidad</td>
									<td>Status</td>
									<td>Opciones</td>
								</tr>
							</thead>
							<tbody>
								<?php 

								$sqlT = mysqli_query($conexion, "SELECT COUNT(*) as total FROM pedidos");
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
										<td colspan='6'>
											No hay pedidos
										</td>
									</tr>
									";
								}


									$sql= "SELECT * from pedidos limit $desde, $xPage";
									$res=mysqli_query($conexion,$sql);
									while ($row=mysqli_fetch_assoc($res)){
										$id_prod = $row['id_prod'];

										$sqlP = "SELECT * FROM productos WHERE id_prod = $id_prod";

										$resultado = $conexion->query($sqlP);
										$rowP = $resultado->fetch_assoc();
								?>
								<tr>
									<td>
										<img src="<?php echo $rowP['img'];?>" width="100px" alt="">
									</td>
									<td title="<?php echo $rowP['nombre'];?>"><?php 
											echo $rowP['nombre'];
										?>
									</td>
									<td><?php 
											echo $row['pago'];
										?>
									</td>
									<td><?php 
											echo $row['cantidad'];
										?>
									</td>
									<td>
					   				<?php 
					   					if ($row['id_statusPed'] == 1) {
					   				?>
					   					<span class="status delivered">Entregado</span>
					   				<?php  
					   					}elseif ($row['id_statusPed'] == 2){
					   				?>		
					   					<span class="status pending">Pendiente</span>
					   				<?php
					   					}elseif ($row['id_statusPed'] == 3){
					   				?>		
					   					<span class="status inProgress">En Progreso</span>
					   				<?php
					   					}elseif ($row['id_statusPed'] == 4){
					   				?>		
					   					<span class="status return">Cancelado</span>
					   				<?php
					   					}
					   				?>
					   					
					   					
					   				</td>
									<td>
										<div class="btns2">
		<?php 
			if ($row['id_statusPed'] != 1){
				if ($row['id_statusPed'] != 4){
		?>
		<?php 
				if ($row['id_statusPed'] != 3){
		?>
											<button class="edit" title="En proceso" onclick="proceso(<?php echo $row['id_ped'];?>)">
										 		<ion-icon name="refresh-outline"></ion-icon>
										 	</button>
										  <?php		
						   					}
						   				?>
		
										 	<button class="edit entregado" title="Entregado" onclick="entregar(<?php echo $row['id_ped'];?>)">
										 		<ion-icon name="bag-check-outline"></ion-icon>
										 	</button>

										<?php 
						   					if ($row['id_statusPed'] == 2){
						   				?>
						   					<button title="Cancelar" class="delete" onclick="cancelar(<?php echo $row['id_ped'];?>)">
						   						<ion-icon name="close-outline"></ion-icon>
						   					</button>
						   				<?php		
						   					}
						   				?>
										
						   				<?php
						   						}		
						   					}
						   				?>
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
							<li><a onclick="(paginador(1, 'reload/r-pedidos.php'))">|<</a></li>
							<li><a onclick="(paginador(<?php echo $page-1?>, 'reload/r-pedidos.php'))"><<</a></li>
						<?php 
							}
							if ($tPags <= 5) {
								for ($i=1; $i <= $tPags; $i++) { 
									if ($i == $page) {
										echo '<li class="pageSelect">'.$i.'</li>';
									}else{
						?>
										
										<li>
											<a onclick="(paginador(<?php echo $i?>, 'reload/r-pedidos.php'))"><?php echo $i?>
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
											<a onclick="(paginador(<?php echo $i?>, 'reload/r-pedidos.php'))"><?php echo $i?>
											</a>
										</li>'
						<?php
									}
								}
							}
						if ($page != $tPags && $tPags > 0) {
						?>
							<li><a onclick="(paginador(<?php echo $page+1?>, 'reload/r-pedidos.php'))">>></a></li>
							<li><a onclick="(paginador(<?php echo $tPags?>, 'reload/r-pedidos.php'))">>|</a></li>
						<?php 
						}
						?>
						</ul>
					</div>
					
					<input type="text" id="page" value="<?php echo $page?>" hidden>
					
				</div>
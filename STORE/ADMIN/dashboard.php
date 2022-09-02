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
			<!-- Tarjetas -->
	<?php  
		$sql= "SELECT * from pedidos order by fecha limit 8";
		$res=mysqli_query($conexion,$sql);


		$sqlTUsu = mysqli_query($conexion, "SELECT COUNT(*) as user FROM usuarios WHERE id_rol = 2");
		$resTUsu = mysqli_fetch_assoc($sqlTUsu);
		$usuarios = $resTUsu['user'];

		$sqlTVent = mysqli_query($conexion, "SELECT COUNT(*) as vent FROM pedidos WHERE id_statusPed = 1");
		$resTVent = mysqli_fetch_assoc($sqlTVent);
		$ventas = $resTVent['vent'];

		$sqlIngre = "SELECT * FROM pedidos WHERE id_statusPed = 1";
		$resIngre = mysqli_query($conexion, $sqlIngre);

		$resPED = $conexion->query($sql);
		$numPed = $resPED->num_rows;
		while ($rowIngre = mysqli_fetch_assoc($resIngre)) {
			$ingresos = $rowIngre['pago'];
			$totales = $totales + $ingresos;
		}
		if ($totales <= 0) {
			$totales = 0;
		}
	?>
			<div class="cardBox">
				<div class="card" title="Usuarios">
					<div>
						<div class="num"><?php echo $usuarios;?></div>
						<div class="cardName">Usuarios</div>
					</div>
					<div class="iconBx">
						<ion-icon name="person-outline"></ion-icon>
					</div>
				</div>
				<div class="card" title="Ventas">
					<div>
						<div class="num"><?php echo $ventas;?></div>
						<div class="cardName">Ventas</div>
					</div>
					<div class="iconBx">
						<ion-icon name="cart-outline"></ion-icon>
					</div>
				</div>
				<div class="card">
					<div>
						<div class="num">234</div>
						<div class="cardName">Proximamente</div>
					</div>
					<div class="iconBx">
						<ion-icon name="chatbubbles-outline"></ion-icon>
					</div>
				</div>
				<div class="card" title="Ingresos">
					<div>
						<div class="num">$<?php echo $totales;?></div>
						<div class="cardName">Ingresos</div>
					</div>
					<div class="iconBx">
						<ion-icon name="cash-outline"></ion-icon>
					</div>
				</div>
			</div>

			<!-- Lista de Pedidos -->
			<div class="details">
				<div class="recentOrders">
					<div class="cardHeader">
						<h2> Pedidos Recientes </h2>
						<a href="pedidos.php" class="btn">Ver Todo</a>
					</div>
					<table>
						<thead>
							<tr>
								<td>Nombre</td>
								<td>Precio</td>
								<td>Pagado</td>
								<td>Status</td>
							</tr>
						</thead>
						<tbody>
	<?php
	if ($numPed > 0) {
	  
		while ($row=mysqli_fetch_assoc($res)){
			$id_prod = $row['id_prod'];

			$sqlP = "SELECT * FROM productos WHERE id_prod = $id_prod";

			$resultado = $conexion->query($sqlP);
			$rowP = $resultado->fetch_assoc();
			$precio = $rowP['precio'];
			$pagado = $row['cantidad'] * $precio;

			if ($pagado == $row['pago']) {
				$paid = 'Pagado';
			}else{
				$paid = 'No pagado';
			}
		
	?>
							<tr>
								<td title="<?php echo $rowP['nombre'];?>"><?php echo $rowP['nombre'];?></td>
								<td><?php echo $rowP['precio'];?></td>
								<td><?php echo $paid;?></td>
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
							</tr>
	<?php 
		} 
	}else{

	
	?>
							<tr>
								<td colspan="4">
									Aun no hay pedidos
								</td>
							</tr>
	<?php
	}
	?>						
						</tbody>
					</table>
				</div>

				<!-- Nuevos Clientes -->
				<div class="recentClients">
					<div class="cardHeader">
						<h2> Clientes Recientes </h2>
					</div>
					<table>
						<?php 
							$sqlUser = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_rol = 2");
							$resUser = $sqlUser;
							while ($rowUser = mysqli_fetch_assoc($resUser)) {
								
						?>
						<tr>
							<td width="60px">
								<div class="imgBx">
									<img src="<?php echo $rowUser['img'];?>" alt="">
								</div>
							</td>
							<td>
								<h4><?php echo $rowUser['usuario'];?><br>
									<!-- <span>Italia</span> -->
								</h4>
							</td>
						</tr>
						<?php 
							}
						?>
					</table>
				</div>
			</div>
		</div>
			<?php require 'require/footer.php'; ?>
		</div>
	</div>

	<?php require('require/scriptsJS.php') ?>}
</body>
</html>
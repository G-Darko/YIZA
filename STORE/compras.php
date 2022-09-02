<?php require 'ADMIN/require/conexion.php';
	require 'ADMIN/require/_config.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Mis compras | <?php echo $mTitle;?></title>
	<!-- <link rel="stylesheet" href="css/style_Store.css">
</head>
<body>
	<div class="contenedor">
		<div class="main"> -->
			<?php require 'require/topbar.php'; ?>
			<div onclick="p()">

		   	<h1 class="titulo"><ion-icon name="bag-check-outline"></ion-icon>&nbsp;Mis Compras / Pedidos</h1>
		   	<div class="productos">
		   	<?php  
		   	if (!isset($_SESSION['id_c'])) {
				header ("Location: login.php");
			}

		   		$sql = "SELECT * FROM pedidos WHERE id_usu = '$id_usu'";
		   		$resultado = $conexion->query($sql);
				$num = $resultado->num_rows;

				$res = mysqli_query($conexion, $sql);
				

				if ($num <= 0) {
					echo '<h1 style="color: var(--negro1);">No has hecho ningúna compra</h1>';
					$block = 'style="display: none;"';
				}
				
		   	?>
			   	<div class="container" <?php echo $block;?>>
			   		
			   		<table>
			   			<tr class="head">
			   				<td></td>
			   				<td></td>
			   				<!-- <td></td>
			   				<td>Producto</td>
			   				<td>Cantidad</td>
			   				<td>Precio por Unidad</td>
			   				<td>Total</td> -->
			   			</tr>
					<?php
			   			while ($row = mysqli_fetch_assoc($res)) {
			   			$id_prod = $row['id_prod'];
			   			$sqlP = "SELECT * FROM productos WHERE id_prod = '$id_prod'";

						$resultado = $conexion->query($sqlP);
						$rowP = $resultado->fetch_assoc();

						$total = $rowP['precio'] * $row['cantidad'];;
			   		?>
			   			<tr>
			   				<td class="left end" style="width: 30%;" rowspan="7">
			   					<img width="100%" src="ADMIN/<?php echo $rowP['img'];?>" alt="">
			   				</td>
			   			</tr>
			   			<tr>
			   				<td class="left" title="<?php echo $rowP['nombre'];?>">
			   					<a href="producto.php?id=<?php echo $id_prod;?>">
			   						Producto:	
			   						<?php echo $rowP['nombre'];?>
			   					</a>
			   				</td>
			   			</tr>
			   			<tr>
			   				<td class="left">
			   					Cantidad:
			   					<?php echo $row['cantidad'];?>
			   				</td>
			   			</tr>
			   			<tr>
			   				<td class="left">
			   				<?php 
			   					if ($row['id_statusPed'] == 2){
			   				?>	
			   					Cancelar: 
			   					<button title="Cancelar" class="delete" onclick="cancelar(<?php echo $row['id_ped'];?>)">
			   						<ion-icon name="close-outline"></ion-icon>
			   					</button>
			   				<?php		
			   					}
			   				?>
			   					
			   				</td>
			   			</tr>
			   			<tr>
			   				
			   				<td class="left">
			   					Se pago:
			   					$<?php echo $row['pago'];?>
			   				</td>
			   			</tr>
			   			<tr>
			   				<td class="left">
			   					Estado: 
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
			   			<tr>
			   				
			   				<td class="left end">
			   					Fecha:
			   					<?php echo $row['fecha'];?>
			   				</td>
			   			</tr>

			   		<?php
			   			}
			   		?>
			   			
			   		</table>
			   	</div>
		   	</div>

		   	
		   </div><!-- p() -->


		</div>
	</div>
   	<?php require 'require/JS.php';?>
   	<script src="require/compras.js"></script>
   	<script>
   		if (localStorage.getItem('search') != ''){
			search.value = '';
			localStorage.setItem('search', '');
		}
   	</script>
   	<?php 
   		if (isset($_GET['r'])){
   			$r = $_GET['r'];
   			if ($r == 'c') {
   	?>
   		<script>
   			Swal.fire({
				icon: 'success',
				title: 'Comprado',
				text: 'Los productos del carrito se han comprado',
				background: '#232323',
			  	color: '#fff',
			  	toast: true,
			  	position: 'bottom-end',
			  	timer: 3000,
			  	timerProgressBar: true
			});
   		</script>	
   	<?php			
   			}
   		} 
   	?>
   	
</body>
</html>

<?php 

	date_default_timezone_set ('America/Mexico_City');
    $fecha = strftime( date('Y')."-".date('m')."-".date('d').' '.date('h').':'.date('i').':'.date('s') );
?>
<?php require 'ADMIN/require/conexion.php';
	require 'ADMIN/require/_config.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Favoritos | <?php echo $mTitle;?></title>
	<!-- <link rel="stylesheet" href="css/style_Store.css">
</head>
<body>
	<div class="contenedor">
		<div class="main"> -->
			<?php require 'require/topbar.php'; ?>
			<div onclick="p()">

		   	<h1 class="titulo"><ion-icon name="heart"></ion-icon>&nbsp;Favoritos</h1>
		   	<div class="productos">
		   	<?php  
		   	if (!isset($_SESSION['id_c'])) {
				header ("Location: login.php");
			}

		   		$sql = "SELECT * FROM favoritos WHERE id_usu = '$id_usu'";
		   		$resultado = $conexion->query($sql);
				$num = $resultado->num_rows;

				$res = mysqli_query($conexion, $sql);
				

				if ($num <= 0) {
					echo '<h1 style="color: var(--negro1);">No hay productos en favoritos</h1>';
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
			   				<td>Opciones</td>
			   				<td>Precio por Unidad</td> -->
			   			</tr>

			   		<?php 
			   			while ($row = mysqli_fetch_assoc($res)) {
			   			$id_prod = $row['id_prod'];
			   			$sqlP = "SELECT * FROM productos WHERE id_prod = '$id_prod'";

						$resultado = $conexion->query($sqlP);
						$rowP = $resultado->fetch_assoc();
			   		?>
			   			<tr>
			   				<td style="width: 30%;" rowspan="4">
			   					<img width="100%" src="ADMIN/<?php echo $rowP['img'];?>" alt="">
			   				</td>
			   			</tr>
			   			<tr>
			   				<td class="left">
			   					<a href="producto.php?id=<?php echo $id_prod;?>">	
			   						Producto:
			   						<?php echo $rowP['nombre'];?>
			   					</a>
			   				</td>
			   			<tr>
			   				<td class="left">
			   					Opciones:
			   					<button title="Añadir al Carrito" class="save" onclick="cart(<?php echo $rowP['id_prod'];?>)">
					   				<ion-icon name="cart-outline"></ion-icon>
					   			</button>

			   					<button title="Eliminar" class="delete" onclick="deleteF(<?php echo $rowP['id_prod'];?>, <?php echo $row['id_fav'];?>)">
			   						<ion-icon name="trash-outline"></ion-icon>
			   					</button>
			   				</td>
			   			</tr>
			   			<tr>

			   				<td class="left end">
			   					Precio Unitario:
			   					$<?php echo $rowP['precio'];?>
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
   	<script src="require/favoritos.js"></script>
   	<script>
   		if (localStorage.getItem('search') != ''){
			search.value = '';
			localStorage.setItem('search', '');
		}
   	</script>
</body>
</html>
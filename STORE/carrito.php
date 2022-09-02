<?php require 'ADMIN/require/conexion.php';
	require 'ADMIN/require/_config.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Carrito | <?php echo $mTitle;?></title>
	<!-- <link rel="stylesheet" href="css/style_Store.css">
</head>
<body>
	<div class="contenedor">
		<div class="main"> -->
			<?php require 'require/topbar.php'; ?>
			<div onclick="p()">

		   	<h1 class="titulo"><ion-icon name="cart-outline"></ion-icon>&nbsp;Carrito de Compras</h1>
		   	<div class="productos">
		   	<?php  
		   	if (!isset($_SESSION['id_c'])) {
				header ("Location: login.php");
			}

		   		$sql = "SELECT * FROM carrito WHERE id_usu = '$id_usu'";
		   		$resultado = $conexion->query($sql);
				$num = $resultado->num_rows;

				$res = mysqli_query($conexion, $sql);
				

				if ($num <= 0) {
					echo '<h1 style="color: var(--negro1);">No hay productos en el carrito</h1>';
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
			   				<td style="width: 30%;" rowspan="5">
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
			   					<input class="cant" id="cantidad<?php echo $row['id_cart'];?>" type="number" min="1" max="<?php echo $rowP['stock'];?>" value="<?php echo $row['cantidad'];?>"> &nbsp;
			   					<button title="Actualizar" class="save" onclick="cartUpdate(<?php echo $rowP['id_prod'];?>, <?php echo $row['id_cart'];?>, <?php echo $rowP['stock'];?>)">
			   						<ion-icon name="refresh"></ion-icon>
			   					</button>
			   					<button title="Eliminar" class="delete" onclick="deleteC(<?php echo $rowP['id_prod'];?>, <?php echo $row['id_cart'];?>)">
			   						<ion-icon name="trash-outline"></ion-icon>
			   					</button>
			   				</td>
			   			</tr>
			   			<tr>
			   				<td class="left">
			   					Precio Unitario: 
			   					$<?php echo $rowP['precio'];?>
			   				</td>
			   			</tr>
			   			<tr>
			   				<td class="left end">
			   					Subtotal:
			   					$<?php echo $total;?>
			   				</td>
			   			</tr>

			   		<?php
			   			$TTotal = $TTotal + $total; 
			   			$id = $rowP['id_prod'];
			   			}
			   		?>
			   			<tr class="total">
			   				
			   				<td style="text-align: right;"><h2>Total:</h2></td>
			   				<td>
			   					<H2>$<?php echo $TTotal;?></H2>
			   				</td>
			   			</tr>
			   			<tr>
			   				<td colspan="2">
				   				<button class="buy" onclick="comprobar(<?php echo $num;?>, <?php echo $TTotal;?>)">
				   					<ion-icon name="card-outline"></ion-icon>
				   					Comprar 
				   				</button>
			   				</td>
			   			</tr>
			   		</table>
			   	</div>
		   	</div>

		   	
		   </div><!-- p() -->


		</div>
	</div>
   	<?php require 'require/JS.php';?>
   	<script src="require/carrito.js"></script>
   	<script>
   		if (localStorage.getItem('search') != ''){
			search.value = '';
			localStorage.setItem('search', '');
		}
   	</script>
</body>
</html>

<?php 

	date_default_timezone_set ('America/Mexico_City');
    $fecha = strftime( date('Y')."-".date('m')."-".date('d').' '.date('h').':'.date('i').':'.date('s') );
?>
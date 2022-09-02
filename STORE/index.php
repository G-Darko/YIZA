<?php require 'ADMIN/require/conexion.php';
	require 'ADMIN/require/_config.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $mTitle;?></title>
	<meta name="description" content="<?php echo $metaDes;?>">
	<meta name="keywords" content="<?php echo $metaClave;?>">
	<!-- <link rel="stylesheet" href="css/style_Store.css">
</head>
<body>
	<div class="contenedor">
		<div class="main"> -->
			<?php require 'require/topbar.php'; ?>
			<div onclick="p()">
				
			<?php 
				$sqlT = mysqli_query($conexion, "SELECT COUNT(*) as total FROM marcas");
				$resT = mysqli_fetch_assoc($sqlT);
				$total = $resT['total'];
				$width = $total*100;

				$marcas = "SELECT * FROM marcas";
				$rm = mysqli_query($conexion, $marcas);
				if ($total >= 2) {
					
			?>		
			<div class="container-slider">
			   	<div class="slider" id="slider" style="width: <?php echo $width.'%';?>;">
			   		<?php 
						while ($row = mysqli_fetch_assoc($rm)){
					?>

			   		<div class="slider__section">
			   			<a href="marca.php?id=<?php echo $row['id_mar'];?>">
			   				<img src="<?php echo 'ADMIN/'.$row['img'];?>" alt="" class="slider__img">
			   			</a>
			   		</div>

			 		<?php 
			 			}
			 		?>
			   	</div>
			   	<div class="slider_btn slider_btn--right" id="btn-right">
			   		<!-- &#62; -->
			   	</div>
			   	<div class="slider_btn slider_btn--left" id="btn-left">
			   		<!-- &#60; -->
			   	</div>
		   	</div>
		   	<?php 
		   		}
		   	?>


		   	<div class="productos">
		   		<?php 
		   			$prod = "SELECT * FROM productos WHERE id_statusProd = 1 AND precio > 0 LIMIT $iStore";
					$rp = mysqli_query($conexion, $prod);

					$resultado = $conexion->query($prod);
					$num = $resultado->num_rows;

					if ($num <= 0) {
						echo '<h1 style="color: var(--negro1);">No hay productos disponibles</h1>';
					}

					while ($rowP = mysqli_fetch_assoc($rp)){
						/*$numero = $rowP['precio'];
						$entero = intval($numero);
						$decimal = $numero - $entero;
						echo "$numero <br>";
						echo "$entero <br>";
						echo "$decimal";
						if ($decimal == 0) {
							$decimal = null;
						}*/

						$total = $rowP['precio'];
						list($enteros, $decimales) = explode(".", $total);
						if (!isset($decimales)) {
							$decimales = 0;
						}
						$decimales = ".$decimales";
						/*echo "$enteros <br>";
						echo "$decimales <br>";*/
						$format_number1 = number_format($decimales, 2);
						$decim = explode(".", $format_number1);

						if($decimales == 0 || $decim == "00"){
							$decimales = null;
							$decim[1] = '00';
						}
						/*echo "$enteros <br>";
						echo "$decimales <br>";
						echo "$decim[1] <br>";
						echo "$format_number1";*/
		   		?>
			   		<div class="content">
			   			<a href="producto.php?id=<?php echo $rowP['id_prod'];?>">
				   			<img src="ADMIN/<?php echo $rowP['img'];?>" alt="<?php echo $rowP['nombre'];?>">

				   			<h1 title="$ <?php echo $rowP['precio'];?>">$ <?php echo $enteros;?><span><?php echo $decim[1];?></span></h1>

				   			<h3 title="<?php echo $rowP['nombre'];?>"><?php echo $rowP['nombre'];?></h3>
					<?php 
				   		$stock = $rowP['stock'];
				   		if ($stock <= 0) {
					?>
				   			<br><br><br><h3 style="color: var(--azul); max-height:20px;" title="<?php echo $leyenda;?>"><?php echo $leyenda;?></h3>
					<?php				   			
				   		}else{
				   			if ($showStock == "SI") {
				   				// code...
								   			
				   	?>
				   			<br><br><br><h3 style="color: var(--azul); max-height:20px;" title="Stock: <?php echo $stock;?>">Stock: <?php echo $stock;?></h3>
				   	<?php
				   			}
				   		}
				   	?>
			   			</a>
			   			<button class="add" onclick="cart(<?php echo $rowP['id_prod'];?>)">
			   				<ion-icon name="cart-outline"></ion-icon>
			   			</button>
			   			<button class="fav" onclick="fav(<?php echo $rowP['id_prod'];?>)">
			   				<ion-icon name="heart"></ion-icon>
			   			</button>
			   		</div>

			   	<?php 
			   		}
			   	?>

		   	</div>

		   </div><!-- p() -->


		</div>
	</div>
   	<?php require 'require/JS.php';?>
   	<script src="require/slider.js"></script>
   	<script>
   		if (localStorage.getItem('search') != ''){
			search.value = '';
			localStorage.setItem('search', '');
		}
   	</script>
</body>
</html>
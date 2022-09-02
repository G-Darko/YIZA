<?php require 'ADMIN/require/conexion.php';
	require 'ADMIN/require/_config.php';
	$id_prod = $_GET['id'];
	$prod = mysqli_query($conexion, "SELECT * FROM productos where id_prod = $id_prod");
	$resProd = $prod;
	$rProd = mysqli_fetch_assoc($resProd);
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $rProd['nombre'];?> | <?php echo $mTitle;?></title>
	<meta name="description" content="<?php echo $rProd['metaDes'];?>">
	<meta name="keywords" content="<?php echo $rProd['metaClave'];?>">
	<!-- <link rel="stylesheet" href="css/style_Store.css">
</head>
<body>
	<div class="contenedor">
		<div class="main"> -->
			<?php require 'require/topbar.php'; ?>
			<div onclick="p()">
				<?php 
						$total = $rProd['precio'];
						list($enteros, $decimales) = explode(".", $total);
						if (!isset($decimales)) {
							$decimales = 0;
						}
						$decimales = ".$decimales";
						$format_number1 = number_format($decimales, 2);
						$decim = explode(".", $format_number1);

						if($decimales == 0 || $decim == "00"){
							$decimales = null;
							$decim[1] = "00";
						}
						$id_mar = $rProd['id_mar'];
						$mar = mysqli_query($conexion, "SELECT * FROM marcas where id_mar = $id_mar");
						$resMar = $mar;
						$rMar = mysqli_fetch_assoc($resMar);

						$id_cat = $rProd['id_cat'];
						$cat = mysqli_query($conexion, "SELECT * FROM categorias where id_cat = $id_cat");
						$resCat = $cat;
						$rCat = mysqli_fetch_assoc($resCat);
				?>
				<div class="fondo">
					<div class="contentProd">
						<div class="img">
							<img src="ADMIN/<?php echo $rProd['img'];?>" alt="">
						</div>
						<div class="aside">
							<h2 title="<?php echo $rProd['nombre'];?>"><?php echo $rProd['nombre'];?></h2>
							<h1 title="$ <?php echo $rProd['precio'];?>">$ <?php echo $enteros;?><span><?php echo $decim[1];?></span></h1>
							<h6>
								Marca: <a href="marca.php?id=<?php echo $rProd['id_mar'];?>&page=1"><?php echo $rMar['nombre'];?></a><br>
								Categoría: <a href="categoria.php?id=<?php echo $rProd['id_cat'];?>&page=1"><?php echo $rCat['nombre'];?></a>
							</h6>
							<h4>Descripción</h4>
							<h5><?php echo $rProd['des'];?></h5>
					<?php 
				   		$stock = $rProd['stock'];
				   		if ($stock <= 0) {
					?>
				   			<br><br><br><h3 style="color: var(--azul); max-height:20px;" title="<?php echo $leyenda;?>"><?php echo $leyenda;?></h3>
					<?php				   			
				   		}else{
				   			if ($showStock == "SI") {
								   			
				   	?>
				   			<br><br><br><h3 style="color: var(--azul); max-height:20px;" title="Stock: <?php echo $stock;?>">Stock: <?php echo $stock;?></h3>
				   	<?php
				   			}
				   		}
				   	?>
						</div>
						<button class="add cpi" onclick="cart(<?php echo $rProd['id_prod'];?>)">
			   				<ion-icon name="cart-outline"></ion-icon>
			   			</button>
			   			<button class="fav cpi" onclick="fav(<?php echo $rProd['id_prod'];?>)">
			   				<ion-icon name="heart"></ion-icon>
			   			</button>
					</div>
				</div>
			</div><!-- p() -->


		</div>
	</div>
   	<?php require 'require/JS.php';?>
</body>
</html>
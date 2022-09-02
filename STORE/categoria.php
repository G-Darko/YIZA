<?php require 'ADMIN/require/conexion.php';
	require 'ADMIN/require/_config.php';
	$id_cat = $_GET['id'];
	$cat = mysqli_query($conexion, "SELECT * FROM categorias where id_cat = $id_cat");
	$resCat = $cat;
	$rCat = mysqli_fetch_assoc($resCat);
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $rCat['nombre'];?> | <?php echo $mTitle;?></title>
	<meta name="description" content="<?php echo $rCat['metaDes'];?>">
	<meta name="keywords" content="<?php echo $rCat['metaClave'];?>">
	<!-- <link rel="stylesheet" href="css/style_Store.css">
</head>
<body>
	<div class="contenedor">
		<div class="main"> -->
			<?php require 'require/topbar.php'; ?>
			<div onclick="p()">

		   	<h1 class="titulo"><?php echo $rCat['nombre'];?></h1>
		   	<div class="productos">
		   		<?php 

		   		$sqlT = mysqli_query($conexion, "SELECT COUNT(*) as total FROM productos WHERE id_statusProd = 1 AND precio > 0 AND id_cat = $id_cat");
				$resT = mysqli_fetch_assoc($sqlT);
				$total = $resT['total'];
				$xPage = $iStore;
				if (empty($_GET['page'])) {
					$page = 1;
				}else{
					$page = $_GET['page'];
				}

				 
				$desde = ($page-1) * $xPage;
				$tPags = ceil($total / $xPage);

				if ($page <= 0 || $_GET['page'] <= 0 || ($page > $tPags && $page != 1) || ($_GET['page'] > $tPags && $_GET['page'] != 1) ) {
						header("Location: categoria.php?id=1&page=1");
				}


		   			$prod = "SELECT * FROM productos WHERE id_statusProd = 1 AND precio > 0 AND id_cat = $id_cat LIMIT $desde, $xPage";
					$rp = mysqli_query($conexion, $prod);

					$resultado = $conexion->query($prod);
					$num = $resultado->num_rows;

					if ($num <= 0) {
						echo '<h1 style="color: var(--negro1);">No hay productos disponibles</h1>';
					}

					while ($rowP = mysqli_fetch_assoc($rp)){

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

		   		<div class="paginador">
						<ul>
					<?php 
						if ($page != 1) {
					?>
							<li><a href="categoria.php?id=<?php echo $id_cat;?>&page=1">|<</a></li>
							<li><a href="categoria.php?id=<?php echo $id_cat;?>&page<?php echo $page-1;?>"><<</a></li>
					<?php 
						}
							if ($tPags <= 5) {
								for ($i=1; $i <= $tPags; $i++) { 
									if ($i == $page) {
										echo '<li class="pageSelect">'.$i.'</li>';
									}else{
										echo '<li><a href="categoria.php?id='.$id_cat.'&page='.$i.'">'.$i.'</a></li>';
									}
								}
							}else{
								for ($i = max(1, min($page, $tPags - 5)); $i < max(6, min($page + 6, $tPags + 1)); $i++ ) { 
									if ($i == $page) {
										echo '<li class="pageSelect">'.$i.'</li>';
									}else{
										echo '<li><a href="categoria.php?id='.$id_cat.'&page='.$i.'">'.$i.'</a></li>';
									}
								}
							}
						if ($page != $tPags && $tPags > 0) {
					?>
							<li><a href="categoria.php?id=<?php echo $id_cat;?>&page=<?php echo $page+1;?>">>></a></li>
							<li><a href="categoria.php?id=<?php echo $id_cat;?>&page=<?php echo $tPags;?>">>|</a></li>
					<?php 
						}
					?>
						</ul>
				</div>

		   </div><!-- p() -->


		</div>
	</div>
   	<?php require 'require/JS.php';?>
</body>
</html>
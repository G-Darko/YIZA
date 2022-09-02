<?php require 'ADMIN/require/conexion.php';
	$search = $_GET['search'];
	require 'ADMIN/require/_config.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Buscar | <?php echo $mTitle;?></title>
	<!-- <link rel="stylesheet" href="css/style_Store.css">
</head>
<body>
	<div class="contenedor">
		<div class="main"> -->
			<?php require 'require/topbar.php';?>
			<div onclick="p()">

		   	<h1 class="titulo"><ion-icon name="search-outline"></ion-icon>&nbsp; Resultados para la busqueda de <i style="color: var(--azul);"><?php echo $search;?></i></h1>
		   	<?php 
		   		if ($search == "") {
					header('Location: ./');
				}
		   	?>
		   	<div class="productos" <?php echo $block;?>>
		   		<?php 

		   		$SQLmarca = mysqli_query($conexion, "SELECT * FROM marcas WHERE nombre LIKE '%$search%' ");
		   		$rM = mysqli_fetch_assoc($SQLmarca);
		   		$search2 = $rM['id_mar'];

		   		if ($search2 != "") {
		   			$likeM = "$search2";
		   		}else{
		   			$likeM = "";
		   		}

		   		$SQLcategoria = mysqli_query($conexion, "SELECT * FROM categorias WHERE nombre LIKE '%$search%' ");
		   		$rC = mysqli_fetch_assoc($SQLcategoria);
		   		$search3 = $rC['id_cat'];

		   		if ($search3 != "") {
		   			$likeC = "$search3";
		   		}else{
		   			$likeC = "";
		   		}

		   		$sqlT = mysqli_query($conexion, "SELECT COUNT(*) as total FROM productos WHERE id_statusProd = 1 AND precio > 0 AND (nombre LIKE '%$search%' || modelo LIKE '%$search%' || sku LIKE '%$search%' || id_mar LIKE '$likeM' || id_cat LIKE '$likeC') ");
				$resT = mysqli_fetch_assoc($sqlT);
				$total = $resT['total'];
				$xPage = 8;
				if (empty($_GET['page'])) {
					$page = 1;
				}else{
					$page = $_GET['page'];
				}

				 
				$desde = ($page-1) * $xPage;
				$tPags = ceil($total / $xPage);

				if ($page <= 0 || $_GET['page'] <= 0 || ($page > $tPags && $page != 1) || ($_GET['page'] > $tPags && $_GET['page'] != 1) ) {
						header("Location: buscar.php?search=".$search."&page=1");
				}


		   			$prod = "SELECT * FROM productos WHERE id_statusProd = 1 AND precio > 0 AND (nombre LIKE '%$search%' || modelo LIKE '%$search%' || sku LIKE '%$search%' || id_mar LIKE '$likeM' || id_cat LIKE '$likeC') LIMIT $desde, $xPage";
					$rp = mysqli_query($conexion, $prod);

					$resultado = $conexion->query($prod);
					$num = $resultado->num_rows;

					if ($num <= 0) {
						echo '<h1 style="color: var(--negro1);">No se encontraron resultados</h1>';
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
							<li><a href="buscar.php?id=<?php echo $search;?>&page=1">|<</a></li>
							<li><a href="buscar.php?id=<?php echo $search;?>&page<?php echo $page-1;?>"><<</a></li>
					<?php 
						}
							if ($tPags <= 5) {
								for ($i=1; $i <= $tPags; $i++) { 
									if ($i == $page) {
										echo '<li class="pageSelect">'.$i.'</li>';
									}else{
										echo '<li><a href="buscar.php?id='.$search.'&page='.$i.'">'.$i.'</a></li>';
									}
								}
							}else{
								for ($i = max(1, min($page, $tPags - 5)); $i < max(6, min($page + 6, $tPags + 1)); $i++ ) { 
									if ($i == $page) {
										echo '<li class="pageSelect">'.$i.'</li>';
									}else{
										echo '<li><a href="buscar.php?id='.$search.'&page='.$i.'">'.$i.'</a></li>';
									}
								}
							}
						if ($page != $tPags && $tPags > 0) {
					?>
							<li><a href="buscar.php?id=<?php echo $search;?>&page=<?php echo $page+1;?>">>></a></li>
							<li><a href="buscar.php?id=<?php echo $search;?>&page=<?php echo $tPags;?>">>|</a></li>
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
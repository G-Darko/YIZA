	<link rel="stylesheet" href="css/style_Store.css">
	<link rel="icon" href="ADMIN/<?php echo $icon;?>">
</head>
<?php require 'require/session_start.php'; ?>
<body>
	<div class="contenedor">
		<div class="main">
			<div class="topBar">		
				<span class="icon" onclick="yiza()">
					<ion-icon name="storefront-outline"></ion-icon>
					<span class="title" title="<?php echo $comercio;?>"><?php echo $comercio;?></span>
				</span>
				<div class="bordeT"></div>
				<!-- Buscar -->
				<div class="search" onclick="p()">
					<label for="search">
						<div>
							<input type="text" id="search" placeholder="Buscar" required>
							<button onclick="buscar()">
								<ion-icon name="search-outline"></ion-icon>
							</button>
						</div>
					</label>
				</div>

				<div class="carrito">	
					<a href="carrito.php" title="Carrito">
						<span class="option">
							<ion-icon name="cart-outline"></ion-icon>
							
						</span>
					</a>
				</div>

				<!-- UserImg -->
				<div class="user">
				<?php 
					if (!isset($_SESSION['id_c'])) {
				?>
					<ion-icon name="menu-outline"></ion-icon>
				<?php	
					}else{
				?>
					<img src="ADMIN/<?php echo $img;?>" alt="">
				<?php 
					}
				?>
				</div>
				<div class="userMenu">
				<?php 
					if (!isset($_SESSION['id_c'])) {
				?>
					<a href="login.php" title="">
						<span class="option">
							<img src="ADMIN/<?php echo $img;?>" alt="">
							<div>
								<h2 title="Ingresa o Registrate" style="transform: translateY(15px);">Ingresa o Registrate</h2>
							</div>
						</span>
					</a>		
				<?php	
					}else{
				?>
					<a href="perfil.php" title="Perfil">
						<span class="option">
							<img src="ADMIN/<?php echo $img;?>" alt="">
							<div>
								<h2 title="<?php echo $usuario;?>"><?php echo $usuario;?></h2>
								<h6 title="<?php echo $correo;?>"><?php echo $correo;?></h6>
							</div>
						</span>
					</a>
				<?php		
					}
				?>
					<p class="borde"></p>
					<a href="carrito.php">
						<span class="option">
							<ion-icon name="cart-outline"></ion-icon>
							Carrito
						</span>
					</a>
					<a href="favoritos.php">
						<span class="option">
							<ion-icon name="heart-outline"></ion-icon>
							Favoritos
						</span>
					</a>
				<?php 
					if (isset($_SESSION['id_c'])) {
				?>
					<a href="compras.php">
						<span class="option">
							<ion-icon name="bag-check-outline"></ion-icon>
							Mis compras
						</span>
					</a>
					<a href="require/logout.php">
						<span class="option">
							<ion-icon name="log-out-outline"></ion-icon>
							Cerrar Sesión
						</span>
					</a>
				<?php		
					}
				?>
							<!-- Modo Oscuro -->
					<div class="mode">
						<button class="switch" id="switch">
							<span><ion-icon class="sol" name="sunny-sharp"></ion-icon></span>
							<span><ion-icon class="luna" name="moon-sharp"></ion-icon></span>
						</button>
					</div>
				</div>
			</div>
			
	<?php 
	$sql = "SELECT * FROM categorias WHERE id_statusCat = 1 ORDER BY nombre";
	$res=mysqli_query($conexion, $sql);
	$sqlM = "SELECT * FROM marcas ORDER BY nombre";
	$resM=mysqli_query($conexion, $sqlM);
	?>
	<header class="header" onclick="p()">
		<nav>
			<ul>
				<li class="principal">
					<a href="#">Categorias</a>
					<ul>
						<?php 
						while ($row=mysqli_fetch_assoc($res)){
						 ?>
						<li title="<?php echo $row['nombre'];?>">
							<a href="categoria.php?id=<?php echo $row['id_cat'];?>&page=1">
								<?php echo $row['nombre'];?>
							</a>
						</li>
						<?php 
						}
						?>
					</ul>
				</li>

				<li class="principal">
					<a href="#">Marcas</a>
					<ul>
						<?php 
						while ($rowM=mysqli_fetch_assoc($resM)){
						 ?>
						<li title="<?php echo $rowM['nombre'];?>">
							<a href="marca.php?id=<?php echo $rowM['id_mar'];?>&page=1">
								<?php echo $rowM['nombre'];?>
							</a>
						</li>
						<?php 
						}
						?>
					</ul>
				</li>
			</ul>
		</nav>
	</header>
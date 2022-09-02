	<link rel="stylesheet" href="css/style_Admin.css">
	<link rel="icon" href="img/logo-YIZA.png">
</head>
<body class="dark">
	<div class="contenedor">
		<div class="nav">
				<div id="click" onclick="yiza()">
				</div>
			<ul>
				<li>
					<a href="">
						<span class="icon">
							<ion-icon name="storefront-outline"></ion-icon>
						</span>
						<span class="title">YIZA</span>
					</a>
				</li>
				<li class="list">
					<a href="../ADMIN/dashboard.php" title="Inicio">
						<span class="icon">
							<ion-icon name="home-outline"></ion-icon>
						</span>
						<span class="title">Inicio</span>
					</a>
				</li>
				<li class="list">
					<a href="../ADMIN/categorias.php" title="Categorias">
						<span class="icon">
							<ion-icon name="reader-outline"></ion-icon>
						</span>
						<span class="title">Categorias</span>
					</a>
				</li>
				<li class="list">
					<a href="../ADMIN/marcas.php" title="Marcas">
						<span class="icon">
							<ion-icon name="bag-outline"></ion-icon>
						</span>
						<span class="title">Marcas</span>
					</a>
				</li>
				<li class="list">
					<a href="productos.php" title="Productos">
						<span class="icon">
							<ion-icon name="pricetags-outline"></ion-icon>
						</span>
						<span class="title">Productos</span>
					</a>
				</li>
				<li class="list">
					<a href="pedidos.php" title="Pedidos">
						<span class="icon">
							<ion-icon name="cart-outline"></ion-icon>
						</span>
						<span class="title">Pedidos</span>
					</a>
				</li>
				<li class="list">
					<a href="javascript:showModal('config')" title="Configuración">
						<span class="icon">
							<ion-icon name="settings-outline"></ion-icon>
						</span>
						<span class="title">Configuración</span>
					</a>
				</li>
			</ul>
		</div>

		<!-- Main -->
		<div class="main">
			<?php 
			require 'require/_config.php';
			require('../ADMIN/require/topBar.php') ?>
			<div onclick="p()">

				<?php require 'require/config.php';
					
				?>
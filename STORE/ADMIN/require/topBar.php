			<div class="topBar">

				<div class="toggle">
					<ion-icon name="menu-outline"></ion-icon>
				</div>
				<!-- Buscar -->
				<div class="search">
					<!-- <label for="search">
						<input type="text" id="search" placeholder="Buscar Aquí">
						<ion-icon name="search-outline"></ion-icon>
					</label> -->
				</div>
				<!-- Modo Oscuro -->
				<div class="mode">
					<button class="switch" id="switch">
						<span><ion-icon class="sol" name="sunny-sharp"></ion-icon></span>
						<span><ion-icon class="luna" name="moon-sharp"></ion-icon></span>
					</button>
				</div>
				<!-- UserImg -->
				<div class="user" title="Perfil">
					<img src=" <?php echo $img ;?> " alt="">
				</div>
				<div class="userMenu">
					<a href="perfil.php" title="Perfil">
						<span>
							<img src="<?php echo $img ;?>" alt="">
							<div>
								<h2 title="<?php echo "$usuario"; ?>"><?php echo "$usuario"; ?></h2>
								<h6 title="<?php echo "$correo"; ?>"><?php echo "$correo"; ?></h6>
								<h6 title="<?php echo "$rol"; ?>"><?php echo "$rol"; ?></h6>
							</div>
						</span>
					</a>
					<p class="borde"></p>
					<a href="../../STORE" target="_blank" title="Ver Tienda <?php echo $comercio;?>">
						<span>
							<ion-icon name="storefront-outline"></ion-icon>
							<?php echo $comercio;?>
						</span>
					</a>
					<a href="require/logout.php">
						<span>
							<ion-icon name="log-out-outline"></ion-icon>
							Cerrar Sesión
						</span>
					</a>
				</div>
				<div class="bordeT"></div>
			</div>
<?php 
	require('require/conexion.php');
	require 'require/session_start.php';
	
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pedidos | YIZA</title>
<?php require('require/nav_admin.php') ?>
				
			<div id="refresh">
				
			</div>

			<?php 
				require 'require/footer.php'; 
			?>
			</div>
		</div>
	</div>

	<input type="text" id="page" value="1" hidden>

	<?php require('require/scriptsJS.php') ?>}
	
	<script src="require/js/pedidos.js"></script>
</body>
</html>

<!-- <?php
	date_default_timezone_set ('America/Mexico_City');
	echo strftime(date('Y')."-".date('m')."-".date('d')) ;
?> -->
<?php require 'ADMIN/require/conexion.php';
	require 'ADMIN/require/_config.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Mi perfil | <?php echo $mTitle;?></title>
	<meta name="description" content="Gestiona tu perfil en "<?php echo $comercio;?>>
	<meta name="keywords" content="Perfil, "<?php echo $comercio;?>>
	<!-- <link rel="stylesheet" href="css/style_Store.css">
</head>
<body>
	<div class="contenedor">
		<div class="main"> -->
			<?php 
				require 'require/topbar.php'; 
				$sql = "SELECT * FROM usuarios WHERE id_usu = $id_usu";
				$resultado = $conexion->query($sql);
				$num = $resultado->num_rows;
				$row = $resultado->fetch_assoc();
			?>
			<div onclick="p()">

		   	<h1 class="titulo"><ion-icon name="person-outline"></ion-icon>&nbsp;Tu perfil</h1>
		   	<div class="productos">
		   	<?php  
		   	if (!isset($_SESSION['id_c'])) {
				header ("Location: login.php");
			}
		   	?>
			   	<div class="container perfil" id="opciones">
			   		<table>
			   			<tr class="head">
			   				<td></td>
			   			</tr>
			   			<tr style="border: none;">
			   				<td>
			   					<img src="ADMIN/<?php echo $img;?>" alt="">
			   					<i class="i" style="color: var(--azul);"><?php echo $usuario;?></i>
			   				</td>
			   			</tr>
			   			<tr>
			   				<td class="hov" onclick="mostrar('datos')">
			   					<ion-icon name="person-outline"></ion-icon>
			   					Mis datos <span>></span>
			   				</td>
			   			</tr>
			   			<tr>
			   				<td class="hov" onclick="mostrar('seguridad')">
			   					<ion-icon name="lock-closed-outline"></ion-icon>
			   					Seguridad <span>></span>
			   				</td>
			   			</tr>
			   			<tr>
			   				<td class="hov" onclick="mostrar('direccion')">
			   					<ion-icon name="compass-outline"></ion-icon>
			   					Mi dirección <span>></span>
			   				</td>
			   			</tr>
			   		</table>
			   	</div>

			   	<div class="container perfil datos" id="datos" style="display: none;">
			   		<table>
			   			<tr class="head">
			   				<td></td>
			   			</tr>
			   			<tr style="border: none;">
			   				<td>
			   					<ion-icon name="person-outline"></ion-icon>
			   					<i>Mis datos</i>
			   					<span>
			   						<button title="Regresar" onclick="ocultar('datos')">
			   							<ion-icon name="return-up-back-outline"></ion-icon>
			   						</button>
			   					</span>
			   				</td>
			   			</tr>
			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input title="Nombre(s)" class="in" type="text" required id="nombre" value="<?php echo $row['nombres'];?>">
			   						<span class="sp">
			   							<b class="a">*</b>Nombre(s)
			   						</span>
			   					</div>
			   				</td>
			   			</tr>

			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input title="Primer Apellido" class="in" type="text" required id="ap1" value="<?php echo $row['ap1'];?>">
			   						<span class="sp">
			   							<b class="a">*</b>Primer Apellido
			   						</span>
			   					</div>
			   				</td>
			   			</tr>

			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input title="Segundo Apellido" class="in" type="text" required id="ap2" value="<?php echo $row['ap2'];?>">
			   						<span class="sp">Segundo Apellido</span>
			   					</div>
			   				</td>
			   			</tr>

			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input title="Usuario" class="in" type="text" required id="user" value="<?php echo $row['usuario'];?>">
			   						<span class="sp">
			   							<b class="a">*</b>Usuario
			   						</span>
			   					</div>
			   				</td>
			   			</tr>

			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input title="Correo" class="in" type="email" required id="correo" value="<?php echo $row['correo'];?>">
			   						<span class="sp">
			   							<b class="a">*</b>Correo
			   						</span>
			   					</div>
			   				</td>
			   			</tr>
			   			<tr>
			   				<td>
			   					<button class="save data" onclick="updateDatos()">
			   						<ion-icon name="save-outline"></ion-icon>
				   					Guardar cambios
				   				</button>
			   				</td>
			   			</tr>

			   		</table>
			   	</div>


			   	<div class="container perfil datos" id="seguridad" style="display: none;">
			   		<table>
			   			<tr class="head">
			   				<td></td>
			   			</tr>
			   			<tr style="border: none;">
			   				<td>
			   					<ion-icon name="lock-closed-outline"></ion-icon>
			   					<i>Seguridad</i>
			   					<span>
			   						<button title="Regresar" onclick="ocultar('seguridad')">
			   							<ion-icon name="return-up-back-outline"></ion-icon>
			   						</button>
			   					</span>
			   				</td>
			   			</tr>
			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input class="in" type="password" required id="pass" title="Contraseña" autocomplete="off">
			   						<span class="sp">
			   							<b class="a">*</b>Contraseña
			   						</span>
			   						<span class="iconic btnPass c" title="Mostrar Contraseña">
	                                    <ion-icon name="eye-outline"></ion-icon>
	                                </span>
			   					</div>
			   				</td>
			   			</tr>

			   			<tr>
			   				<td>
			   					<div class="inputBox">

			   						<input class="in" type="password" required id="npass" title="Nueva contraseña" autocomplete="off">
			   						

			   						<span class="sp">
			   							<b class="a">*</b>Nueva contraseña
			   						</span>

	                                <span class="iconic btnPass n" title="Mostrar Contraseña">
	                                    <ion-icon name="eye-outline"></ion-icon>
	                                </span>

			   					</div>
			   				</td>
			   			</tr>

			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input class="in" type="password" required id="cnpass"  title="Confirmar nueva contraseña" autocomplete="off">
			   						<span class="sp">
			   							<b class="a">*</b>Confirmar nueva contraseña
			   						</span>
			   						<span class="iconic btnPass cn" title="Mostrar Contraseña">
	                                    <ion-icon name="eye-outline"></ion-icon>
	                                </span>
			   					</div>
			   				</td>
			   			</tr>

			   			
			   			<tr>
			   				<td>
			   					<button class="save data" onclick="updatePass()">
			   						<ion-icon name="save-outline"></ion-icon>
				   					Guardar la nueva contraseña
			   						<ion-icon name="key-outline"></ion-icon>
				   				</button>
			   				</td>
			   			</tr>

			   		</table>
			   	</div>

			   	<?php 
			   		$sqlD = "SELECT * FROM direccion WHERE id_usu = $id_usu";
			   		$resD = $conexion->query($sqlD);
					$num = $resD->num_rows;
					$dir = $resD->fetch_assoc();
			   	?>

			   	<div class="container perfil datos" id="direccion" style="display: none;">
			   		<table>
			   			<tr class="head">
			   				<td></td>
			   			</tr>
			   			<tr style="border: none;">
			   				<td>
			   					<ion-icon name="navigate-circle-outline"></ion-icon>
			   					<i>Dirección</i>
			   					<span>
			   						<button title="Regresar" onclick="ocultar('direccion')">
			   							<ion-icon name="return-up-back-outline"></ion-icon>
			   						</button>
			   					</span>
			   				</td>
			   			</tr>

			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input class="in" type="text" required id="nex" title="Número Exterior" maxlength="5" value="<?php echo $dir['no_exterior'];?>">
			   						<span class="sp">
			   							<b class="a">*</b>N° Exterior
			   						</span>
			   					</div>
			   				</td>
			   			</tr>
			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input class="in" type="text" required id="nix" title="Número Interior" maxlength="5" value="<?php echo $dir['no_interior'];?>">
			   						<span class="sp">
			   							N° interior
			   						</span>
			   					</div>
			   				</td>
			   			</tr>
			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input class="in" type="number" required id="cp" title="Código Postal" maxlength="5" value="<?php echo $dir['cod_postal'];?>">
			   						<span class="sp">
			   							<b class="a">*</b>Código Postal
			   						</span>
			   					</div>
			   				</td>
			   			</tr>

			   			<?php
			   				$id_estado = $dir['id_estados'];

			   				if ($num == 1) {
				   				$sqlEs = "SELECT * FROM estados WHERE id_estados = $id_estado"; 
				   				$resE = $conexion->query($sqlEs);
								$es = $resE->fetch_assoc();

				   				$sqlE = "SELECT * FROM estados WHERE id_estados != $id_estado";
			   				}else{
			   					$sqlE = "SELECT * FROM estados";
			   				}


			   				

			   				$restado=mysqli_query($conexion, $sqlE);
			   			?>

			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<select id="estado" class="in" required>
			   			<?php 
			   			if ($num == 1) {
			   			?>
			   							<option value="<?php echo $es['id_estados'];?>"><?php echo $es['nombre'];?></option>
			   			<?php
			   			}
			   				while ($estado = mysqli_fetch_assoc($restado)){
			   			?>
			   							<option value="<?php echo $estado['id_estados'];?>"><?php echo $estado['nombre'];?></option>
			   			<?php 
			   				}
			   			?>
			   						</select>
			   						<span class="sp">
			   							<b class="a">*</b>Estado
			   						</span>
			   					</div>
			   				</td>
			   			</tr>

			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input class="in" type="text" required id="colonia" title="Colonia" value="<?php echo $dir['colonia'];?>">
			   						<span class="sp">
			   							<b class="a">*</b>Colonia
			   						</span>
			   					</div>
			   				</td>
			   			</tr>
			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input class="in" type="text" required id="calle" title="Calle" value="<?php echo $dir['calle'];?>">
			   						<span class="sp">
			   							<b class="a">*</b>Calle
			   						</span>
			   					</div>
			   				</td>
			   			</tr>
			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input class="in" type="text" required id="municipio" title="Municipio" value="<?php echo $dir['municipio'];?>">
			   						<span class="sp">
			   							<b class="a">*</b>Municipio
			   						</span>
			   					</div>
			   				</td>
			   			</tr>

			   	<?php 
			   		if ($num == 1) {
			   	?>
			   			<tr>
			   				<td>
			   					<button class="save data" onclick="updateDir()">
			   						<ion-icon name="map-outline"></ion-icon>
				   					Guardar la dirección
				   				</button>
			   				</td>
			   			</tr>
			   	<?php
			   		}else{
			   	?>
			   			<tr>
			   				<td>
			   					<button class="save data" onclick="insertDir()">
			   						<ion-icon name="map-outline"></ion-icon>
				   					Agregar dirección
				   				</button>
			   				</td>
			   			</tr>
			   	<?php } ?>

			   		</table>
			   	</div>

		   	</div>

		   	
		   </div><!-- p() -->


		</div>
	</div>
   	<?php require 'require/JS.php';?>
   	<script src="require/perfil.js"></script>
   	<script>
   		if (localStorage.getItem('search') != ''){
			search.value = '';
			localStorage.setItem('search', '');
		}
   	</script>
<?php 
	if (isset($_GET['r']) && $num == 0) {
		$r = $_GET['r'];
		if ($r == 'direccion') {
?>
	<script>
		mostrar('direccion');
		Swal.fire({
           icon: 'info',
           title: 'Agrega tu dirección',
           text: ('Agrega una direccion para poder comprar'),
           background: '#232323',
           color: '#fff',
           toast: true,
           position: 'bottom-end',
           timer: 5000,
           timerProgressBar: true,
           showConfirmButton: false
         });
	</script>
<?php			
		}
	}
?>
</body>
</html>
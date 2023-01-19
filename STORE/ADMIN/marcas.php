<?php 
	require('require/conexion.php');
	require 'require/session_start.php';
	
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<title>Marcas | YIZA</title>
<?php require('require/nav_admin.php') ?>

			<div id="refresh">
				
			</div>

				<div class="modal" id="modal-NMar" style="display: none;">
					<div class="container auto">
						<div class="header">
							<h2>
								<ion-icon name="add-outline"></ion-icon>
								Nueva Marca
							</h2>
							<button title="Cerrar" class="btnClose" onclick="hideModal('modal-NMar')">
								<ion-icon name="close-circle-outline"></ion-icon>
							</button>
						</div>
						<div class="inputBx">
							<input type="text" id="nombre" required>
							<label>
								<span class="a">*</span>
								Nombre
							</label>
						</div>
						<div class="inputBx">
							<img class="cuadro" id="cuadro" src="img/logo3.png" alt="Imagen predeterminada de Marcas" onclick="subir('img')">
							<input type="file" id="img" required onchange="imagenChange('img', 'cuadro', 'img/logo3.png')" hidden>
							<label>
								Imagen
							</label>
						</div>

						<button title="Agregar" class="savePass" onclick="agregarMar()">
							<ion-icon name="bag-add-outline"></ion-icon>
							Agregar
						</button>
					</div>
				</div>

				<div class="modal" id="modal-Edit" style="display: none;">
					<div class="container auto">
						<div class="header">
							<h2>
								<ion-icon name="pencil-outline"></ion-icon>
								Editar Marca
							</h2>
							<button title="Cerrar" class="btnClose" onclick="hideModal('modal-Edit')">
								<ion-icon name="close-circle-outline"></ion-icon>
							</button>
						</div>

						<div class="inputBx">
							<input type="hidden" value="" id="id_mar">
							<input type="text" id="nombre-e" required>
							<label>
								<span class="a">*</span>
								Nombre
							</label>
						</div>
						<div class="inputBx">
							<img id="img-e" class="cuadro" src="" onclick="subir('inputImg')">
							<input type="file" id="inputImg" required hidden onchange="imagenChange('inputImg', 'img-e', document.getElementById('img-e').src)">
							<label>
								Imagen
							</label>
						</div>

						<button title="Actualizar" class="savePass" onclick="updateMar()">
							<ion-icon name="save-outline"></ion-icon>
							Guardar Cambios
						</button>
					</div>
				</div>

			<?php 
				require 'require/footer.php';
			?>
			
			</div>
		</div>
	</div>
	
	<input type="text" id="page" value="1" hidden>

	<?php require('require/scriptsJS.php') ?>
	
	<script src="require/js/marcas.js"></script>
</body>
</html>

<!-- <?php
	date_default_timezone_set ('America/Mexico_City');
	echo strftime(date('Y')."-".date('m')."-".date('d')) ;
?> -->
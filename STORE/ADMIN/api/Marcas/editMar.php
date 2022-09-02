<?php 
	require '../../require/conexion.php';
	$response = new stdClass();
	//$response->state=true;

	$id_mar = $_POST['id_mar'];
	$nombre = $_POST['nombre-e'];

	$order   = '"';
	$replace = '&quot;';
	$nombre = str_replace($order, $replace, $nombre);

	if ( (strpos($nombre, '<') !== false || strpos($nombre, '>') !== false) ){
	    $response->state=false;
		$response->detail="No se permiten los caracteres <, >";
	}elseif (strlen($nombre)>255){
      	$response->state=false;
		$response->detail="El campo Nombre no puede superar 255 caracteres";
   }elseif ($nombre == "") {
		$response->state=false;
		$response->detail="El campo Nombre no puede estar vacio";
	}else{
		
		//$response->state=true;
		if ($_FILES['inputImg']['error'] > 0) {
			$response->state=false;
			$response->detail="Error al subir archivo";
		}else{
			$nombreImg = $_FILES['inputImg']['name'];
			$tipo = $_FILES['inputImg']['type'];
			$size = $_FILES['inputImg']['size'];
			$tmp = $_FILES['inputImg']['tmp_name'];
			if ( !($nombreImg == "")) {
				
				if ($size <= 5000000) {
					if ($tipo == "image/png" || $tipo == "image/jpg" || $tipo == "image/jpeg" || $tipo == "image/gif") {
						
						$ruta = "../../img/marcas/";
						$archivo = $ruta.$nombreImg;
						if (!file_exists($ruta)) {
							mkdir($ruta);
						}
						if (!file_exists($archivo)) {
							move_uploaded_file($tmp, $archivo);
							$subir = "img/marcas/".$nombreImg;
							$sql = "UPDATE marcas SET nombre = '$nombre', img = '$subir' where id_mar = $id_mar";
							$resultado = mysqli_query($conexion, $sql);
								if ($resultado) {
									$response->state=true;
								}else{
									$response->state=false;
									$response->detail="Error al actualizar";
								}
						}else{
							/*$response->state=false;
							$response->detail="El archivo ya existe";*/
							move_uploaded_file($tmp, $archivo);
							$subir = "img/marcas/".$nombreImg;
							$sql = "UPDATE marcas SET nombre = '$nombre', img = '$subir' where id_mar = $id_mar";
							$resultado = mysqli_query($conexion, $sql);
								if ($resultado) {
									$response->state=true;
								}else{
									$response->state=false;
									$response->detail="Error al actualizar";
								}
						}
					}else{
						$response->state=false;
						$response->detail="Solo se adminten imagenes (png, jpg, jpeg, gif)";
					}
					
				}else{
					$response->state=false;
					$response->detail="El tamaño no puede ser mayor a 5 MB";
				}
			}else{
				//$response->state=false;
				//$response->detail="El archivo no puede estar vacío";
				$sql = "UPDATE marcas SET nombre = '$nombre' where id_mar = $id_mar";
				$resultado = mysqli_query($conexion, $sql);
					if ($resultado) {
						$response->state=true;
					}else{
						$response->state=false;
						$response->detail="Error al actualizar";
					}
			}
		}
					
	}
	
	echo json_encode($response);
?>
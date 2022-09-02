<?php 
	require '../../require/conexion.php';
	$response = new stdClass();
	$nombre = $_POST['nombre'];

	$order   = '"';
	$replace = '&quot;';
	$nombre = str_replace($order, $replace, $nombre);

	if ( (strpos($nombre, '<') !== false || strpos($nombre, '>') !== false) ){
	    $response->state=false;
		$response->detail="No se permiten los caracteres <, >";
	}elseif (strlen($nombre)>255){
      	$response->state=false;
		$response->detail="El campo Nombre no puede superar 255 caracteres";
   }elseif ($nombre == ''){
   		$response->state=false;
		$response->detail="El campo Nombre no puede estar vacío";
   }else{

		//$response->state=true;
		if ($_FILES['img']['error'] > 0) {
			$response->state=false;
			$response->detail="Error al subir archivo";
		}else{
			$nombreImg = $_FILES['img']['name'];
			$tipo = $_FILES['img']['type'];
			$size = $_FILES['img']['size'];
			$tmp = $_FILES['img']['tmp_name'];
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
							$sql = "INSERT INTO marcas VALUES (null, '$nombre', '$subir')";
							$resultado = mysqli_query($conexion, $sql);
								if ($resultado) {
									$response->state=true;
								}else{
									$response->state=false;
									$response->detail="Error al subir";
								}
						}else{
							/*$response->state=false;
							$response->detail="El archivo ya existe";*/
							move_uploaded_file($tmp, $archivo);
							$subir = "img/marcas/".$nombreImg;
							$sql = "INSERT INTO marcas VALUES (null, '$nombre', '$subir')";
							$resultado = mysqli_query($conexion, $sql);
								if ($resultado) {
									$response->state=true;
								}else{
									$response->state=false;
									$response->detail="Error al subir";
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
				move_uploaded_file($tmp, $archivo);
				$subir = "img/marcas/".$nombreImg;
				$sql = "INSERT INTO marcas VALUES (null, '$nombre', 'img/logo3.png')";
				$resultado = mysqli_query($conexion, $sql);
					if ($resultado) {
						$response->state=true;
					}else{
						$response->state=false;
						$response->detail="Error al subir";
					}
			}
		}
   }
	echo json_encode($response);

?>
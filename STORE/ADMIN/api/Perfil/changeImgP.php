<?php 
	require '../../require/conexion.php';
	require '../../require/session_start.php';
	$response = new stdClass();
	//$response->state=true;
	if ($id_rol == 1) {
		$rol="_admin";
	}elseif ($id_rol == 2) {
		$rol="_user";
	}
	if ($_FILES['img']['error'] > 0) {
		$response->state=false;
		$response->detail="Error al subir archivo";
	}else{
		$nombre = $_FILES['img']['name'];
		$tipo = $_FILES['img']['type'];
		$size = $_FILES['img']['size'];
		$tmp = $_FILES['img']['tmp_name'];
		if ( !($nombre == "")) {
			
			if ($size <= 5000000) {
				if ($tipo == "image/png" || $tipo == "image/jpg" || $tipo == "image/jpeg" || $tipo == "image/gif") {
					
					$ruta = "../../img/".$rol."/".$id_usu."/";
					$archivo = $ruta.$nombre;
					if (!file_exists($ruta)) {
						mkdir($ruta);
					}
					if (!file_exists($archivo)) {
						move_uploaded_file($tmp, $archivo);
						$subir = "img/".$rol."/".$id_usu."/".$nombre;
						$sql = "UPDATE usuarios set img = '$subir' where id_usu = $id_usu ";
						$resultado = mysqli_query($conexion, $sql);
							if ($resultado) {
								$response->state=true;
								$_SESSION['img'] = $subir;
							}else{
								$response->state=false;
								$response->detail="Error al subir";
								$sql = "UPDATE usuarios set img = '$img' where id_usu = $id_usu";
								$resultado = mysqli_query($conexion, $sql);
									if ($resultado) {
										$response->state=false;
										$_SESSION['img'] = $img;
									}
							}
					}else{
						/*$response->state=false;
						$response->detail="El archivo ya existe";*/
						move_uploaded_file($tmp, $archivo);
						$subir = "img/".$rol."/".$id_usu."/".$nombre;
						$sql = "UPDATE usuarios set img = '$subir' where id_usu = $id_usu ";
						$resultado = mysqli_query($conexion, $sql);
							if ($resultado) {
								$response->state=true;
								$_SESSION['img'] = $subir;
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
			$response->state=false;
			$response->detail="El archivo no puede estar vacío";
			$sql = "UPDATE usuarios set img = '$img' where id_usu = $id_usu";
			$resultado = mysqli_query($conexion, $sql);
				if ($resultado) {
					$response->state=false;
					$_SESSION['img'] = $img;
				}
		}
	}
	echo json_encode($response);

?>
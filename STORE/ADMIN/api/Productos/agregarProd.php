<?php 
	require '../../require/conexion.php';
	$response = new stdClass();

	$nombre = $_POST['nombre'];
	$des = $_POST['des'];
	$tMeta = $_POST['tMeta'];
	$desMeta = $_POST['desMeta'];
	$clave = $_POST['clave'];
	$modelo = $_POST['modelo'];
	$sku = $_POST['sku'];
	$precio = $_POST['precio'];
	$stock = $_POST['stock'];
	$status = $_POST['status'];
	$id_mar = $_POST['id_mar'];
	$id_cat = $_POST['id_cat'];

	$order   = '"';
	$replace = '&quot;';

	$nombre = str_replace($order, $replace, $nombre);
	$des = str_replace($order, $replace, $des);
	$tMeta = str_replace($order, $replace, $tMeta);
	$desMeta = str_replace($order, $replace, $desMeta);
	$clave = str_replace($order, $replace, $clave);
	$modelo = str_replace($order, $replace, $modelo);
	$sku = str_replace($order, $replace, $sku);


	if (	
	(strpos($nombre, '<') !== false || strpos($nombre, '>') !== false) || 
	(strpos($des, '<') !== false || strpos($des, '>') !== false) ||
	(strpos($tMeta, '<') !== false || strpos($tMeta, '>') !== false) ||
	(strpos($desMeta, '<') !== false || strpos($desMeta, '>') !== false) ||
	(strpos($clave, '<') !== false || strpos($clave, '>') !== false) ||
	(strpos($modelo, '<') !== false || strpos($modelo, '>') !== false) ||
	(strpos($sku, '<') !== false || strpos($sku, '>') !== false) 
	){
	    $response->state=false;
		$response->detail="No se permiten los caracteres <, >";
	}elseif (strlen($nombre)>255){
      	$response->state=false;
		$response->detail="El campo Nombre no puede superar 255 caracteres";
   }elseif (strlen($tMeta)>255){
      	$response->state=false;
		$response->detail="El campo Titulo Meta Tag no puede superar 255 caracteres";
   }elseif ($nombre == "") {
		$response->state=false;
		$response->detail="El campo Nombre no puede estar vacio";
	}elseif ($tMeta == "") {
		$response->state=false;
		$response->detail="El campo Titulo Meta Tag no puede estar vacio";
	}elseif ($modelo == "") {
		$response->state=false;
		$response->detail="El campo Modelo no puede estar vacio";
	}elseif ($id_mar == "") {
		$response->state=false;
		$response->detail="La marca no fue seleccionada";
	}elseif ($id_cat == "") {
		$response->state=false;
		$response->detail="La categoría no fue seleccionada";
	}else{
		if ($precio == "") {
			$precio = 0;
		}
		if ($stock == "") {
			$stock = 0;
		}
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
						
						$ruta = "../../img/productos/";
						$archivo = $ruta.$nombreImg;
						if (!file_exists($ruta)) {
							mkdir($ruta);
						}
						if (!file_exists($archivo)) {
							move_uploaded_file($tmp, $archivo);
							$subir = "img/productos/".$nombreImg;
							$sql = "INSERT INTO productos VALUES (null, '$nombre', '$des', '$tMeta', '$desMeta', '$clave', '$modelo', '$sku', $precio, $stock, '$subir', $id_mar, $id_cat, $status)";
							$resultado = mysqli_query($conexion, $sql);
								if ($resultado) {
									$response->state=true;
								}else{
									$response->state=false;
									$response->detail="Error al agregar";
								}
						}else{
							/*$response->state=false;
							$response->detail="El archivo ya existe";*/
							move_uploaded_file($tmp, $archivo);
							$subir = "img/productos/".$nombreImg;
							$sql = "INSERT INTO productos VALUES (null, '$nombre', '$des', '$tMeta', '$desMeta', '$clave', '$modelo', '$sku', $precio, $stock, '$subir', $id_mar, $id_cat, $status)";
							$resultado = mysqli_query($conexion, $sql);
								if ($resultado) {
									$response->state=true;
								}else{
									$response->state=false;
									$response->detail="Error al agregar";
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
				$sql = "INSERT INTO productos VALUES (null, '$nombre', '$des', '$tMeta', '$desMeta', '$clave', '$modelo', '$sku', $precio, $stock, 'img/logo.jpg', $id_mar, $id_cat, $status)";
				$resultado = mysqli_query($conexion, $sql);
					if ($resultado) {
						$response->state=true;
					}else{
						$response->state=false;
						$response->detail="Error al agregar";
					}
			}
		}
   }
	echo json_encode($response);

?>
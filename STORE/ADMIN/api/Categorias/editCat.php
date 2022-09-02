<?php 
	require '../../require/conexion.php';
	$response = new stdClass();
	//$response->state=true;

	$id_cat = $_POST['id_cat'];
	$nombre = $_POST['nombre-e'];
	$des = $_POST['des-e'];
	$tMeta = $_POST['tMeta-e'];
	$desMeta = $_POST['desMeta-e'];
	$clave = $_POST['clave-e'];
	$status = $_POST['status-e'];
	$padre = $_POST['padre-e'];

	$order   = '"';
	$replace = '&quot;';
	$nombre = str_replace($order, $replace, $nombre);
	$des = str_replace($order, $replace, $des);
	$tMeta = str_replace($order, $replace, $tMeta);
	$desMeta = str_replace($order, $replace, $desMeta);
	$clave = str_replace($order, $replace, $clave);

	if (	
	(strpos($nombre, '<') !== false || strpos($nombre, '>') !== false) || 
	(strpos($des, '<') !== false || strpos($des, '>') !== false) ||
	(strpos($tMeta, '<') !== false || strpos($tMeta, '>') !== false) ||
	(strpos($desMeta, '<') !== false || strpos($desMeta, '>') !== false) ||
	(strpos($clave, '<') !== false || strpos($clave, '>') !== false) 
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
	}elseif ($padre == "") {
		$response->state=false;
		$response->detail="El campo Padre no fue seleccionado";
	}else{
		
		$sql = "UPDATE categorias SET nombre = '$nombre', descripcion = '$des', metaT = '$tMeta', metaDes = '$desMeta', metaClave = '$clave', id_statusCat = $status where id_cat = $id_cat ";
		$resultado = mysqli_query($conexion, $sql);	
			if ($padre == 0) {
				$sqlP = "UPDATE cPadre SET id_padre = $id_cat where id_cat = $id_cat";
				$resultadoP = mysqli_query($conexion, $sqlP);
				if ($resultadoP) {
					$response->state=true;
				}else{
					$response->state=false;
					$response->detail="Error al actualizar";
				}
			}else{
				$sqlP = "UPDATE cPadre SET id_padre = $padre where id_cat = $id_cat";
				$resultadoP = mysqli_query($conexion, $sqlP);
				if ($resultadoP) {
					$response->state=true;
				}else{
					$response->state=false;
					$response->detail="Error al actualizar";
				}
				
			}
					
	}
	
	echo json_encode($response);
?>
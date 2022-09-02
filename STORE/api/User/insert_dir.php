<?php 
	require('../../ADMIN/require/conexion.php');
	require '../../require/session_start.php';
	$response = new stdClass();
	
	$nex = $_POST['nex'];
	$nix = $_POST['nix'];
	$cp = $_POST['cp'];
	$estado = $_POST['estado'];
	$colonia = $_POST['colonia'];
	$calle = $_POST['calle'];
	$municipio = $_POST['municipio'];

	$order   = '"';
	$replace = '&quot;';
	$nex = str_replace($order, $replace, $nex);
	$nix = str_replace($order, $replace, $nix);
	$cp = str_replace($order, $replace, $cp);
	$estado = str_replace($order, $replace, $estado);
	$colonia = str_replace($order, $replace, $colonia);
	$calle = str_replace($order, $replace, $calle);
	$municipio = str_replace($order, $replace, $municipio);

	if (	
	(strpos($nex, '<') !== false || strpos($nex, '>') !== false) || 
	(strpos($nix, '<') !== false || strpos($nix, '>') !== false) ||
	(strpos($cp, '<') !== false || strpos($cp, '>') !== false) ||
	(strpos($estado, '<') !== false || strpos($estado, '>') !== false) ||
	(strpos($colonia, '<') !== false || strpos($colonia, '>') !== false) ||
	(strpos($calle, '<') !== false || strpos($calle, '>') !== false) ||
	(strpos($municipio, '<') !== false || strpos($municipio, '>') !== false) 
	){
	    $response->state=false;
		$response->detail = "No se permiten los caracteres <, >";
	}elseif ( strlen($nex) > 5){
      	$response->state=false;
		$response->detail = "El campo N° Exterior no puede superar 5 caracteres";
   }elseif ( strlen($nix) > 5){
      	$response->state=false;
		$response->detail = "El campo N° Interior no puede superar 5 caracteres";
   }elseif ( strlen($cp) > 5){
      	$response->state=false;
		$response->detail="El campo Código Postal no puede superar 5 caracteres";
   }elseif (strlen($colonia) > 255){
      	$response->state=false;
		$response->detail="El campo Colonia no puede superar 255 caracteres";
   }elseif (strlen($calle)>255){
      	$response->state=false;
		$response->detail="El campo Calle no puede superar 255 caracteres";
   }elseif (strlen($municipio)>255){
      	$response->state=false;
		$response->detail="El campo Municipio no puede superar 255 caracteres";
   }elseif ($nex == "") {
		$response->state=false;
		$response->detail="El campo N° Exterior no puede estar vacio";
	}elseif ($cp == "") {
		$response->state=false;
		$response->detail="El campo Código Postal no puede estar vacio";
	}elseif ($colonia == "") {
		$response->state=false;
		$response->detail="El campo Colonia no puede estar vacio";
	}elseif ($calle == "") {
		$response->state=false;
		$response->detail="El campo Calle no puede estar vacio";
	}elseif ($municipio == "") {
		$response->state=false;
		$response->detail="El campo Municipio no puede estar vacio";
	}else{

		$sqlC = "SELECT * FROM direccion WHERE id_usu = $id_usu";
		$resultado = $conexion->query($sqlC);
		$num = $resultado->num_rows;
		if ($num == 0) {
			$sql = "INSERT INTO direccion VALUES (null, '$nex', '$nix', $cp, $estado, '$colonia', '$calle','$municipio', $id_usu);";
			$resultado = mysqli_query($conexion, $sql);
			if ($resultado) {
				$response->state=true;
			}else{
				$response->state=false;
				$response->detail="Error al agregar la dirección";
			}			
		}else{
			$response->state=false;
			$response->detail="El usuario ya tiene dirección";
		}

	}

	echo json_encode($response);

?>
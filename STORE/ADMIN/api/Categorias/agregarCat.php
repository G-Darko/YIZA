<?php 
	require '../../require/conexion.php';
	$response = new stdClass();
	//$response->state=true;
	$nombre = $_POST['nombre'];
	$des = $_POST['des'];
	$tMeta = $_POST['tMeta'];
	$desMeta = $_POST['desMeta'];
	$clave = $_POST['clave'];
	$status = $_POST['status'];
	$padre = $_POST['padre'];

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
	}else{
		$sql_tC= "SELECT COUNT(*) as total FROM categorias";
		$resT=mysqli_query($conexion, $sql_tC);
		$row=mysqli_fetch_assoc($resT);
		$id_cat = $row['total'];
		$id_cat= $id_cat+1;

		$catT = "SELECT id_cat from categorias";
		$resCat=mysqli_query($conexion, $catT);
		while ($row2=mysqli_fetch_assoc($resCat)) {
			if ($id_cat == $row2['id_cat']) {
				$id_cat = $id_cat + 1;				
				//return $id_cat;
			}
		}
				$insert = "INSERT into categorias values 
					($id_cat, '$nombre', '$des', '$tMeta', '$desMeta', '$clave', $status)";
				$resultado = mysqli_query($conexion, $insert);		
					if ($padre == 0) {
						$INpadre = "INSERT into cPadre values (null, $id_cat, $id_cat)";
						$resultadoP = mysqli_query($conexion, $INpadre);
						if ($resultadoP) {
							$response->state=true;
						}else{
							$response->state=false;
							$response->detail="Error al agregar";
						}
					}else{
						$INpadre = "INSERT into cPadre values (null, $id_cat, $padre)";
						$resultadoP = mysqli_query($conexion, $INpadre);
						if ($resultadoP) {
							$response->state=true;
						}else{
							$response->state=false;
							$response->detail="Error al agregar";
						}
					}
					
	}
	
	echo json_encode($response);

?>
<?php 
	require '../require/conexion.php';
	$response = new stdClass();

	$nomC = $_POST['nomC'];
	$metaTC = $_POST['metaTC'];
	$metaDesC = $_POST['metaDesC'];
	$metaClaveC = $_POST['metaClaveC'];
	$propietario = $_POST['propietario'];
	$direccionC = $_POST['direccionC'];
	$correoC = $_POST['correoC'];
	$telefonoC = $_POST['telefonoC'];
	$iAdmin = $_POST['iAdmin'];
	$iStore = $_POST['iStore'];
	$showStock = $_POST['showStock'];
	$leyenda = $_POST['leyenda'];

	$order   = '"';
	$replace = '&quot;';
	$nomC = str_replace($order, $replace, $nomC);
	$metaTC = str_replace($order, $replace, $metaTC);
	$metaDesC = str_replace($order, $replace, $metaDesC);
	$metaClaveC = str_replace($order, $replace, $metaClaveC);
	$propietario = str_replace($order, $replace, $propietario);
	$direccionC = str_replace($order, $replace, $direccionC);
	$correoC = str_replace($order, $replace, $correoC);
	$leyenda = str_replace($order, $replace, $leyenda);

	if (	
	(strpos($nomC, '<') !== false || strpos($nomC, '>') !== false) || 
	(strpos($metaTC, '<') !== false || strpos($metaTC, '>') !== false) ||
	(strpos($metaDesC, '<') !== false || strpos($metaDesC, '>') !== false) ||
	(strpos($metaClaveC, '<') !== false || strpos($metaClaveC, '>') !== false) ||
	(strpos($propietario, '<') !== false || strpos($propietario, '>') !== false) ||
	(strpos($direccionC, '<') !== false || strpos($direccionC, '>') !== false) ||
	(strpos($leyenda, '<') !== false || strpos($leyenda, '>') !== false) ||
	(strpos($correoC, '<') !== false || strpos($correoC, '>') !== false) 
	){
	    $response->state=false;
		$response->detail="No se permiten los caracteres <, >";
	} elseif ( strlen($nomC) > 30){
      	$response->state=false;
		$response->detail="El campo Nombre del Comercio no puede superar 30 caracteres";
	} elseif ( strlen($metaTC) > 30){
      	$response->state=false;
		$response->detail="El campo Meta Tag Title no puede superar 30 caracteres";
	} elseif ( strlen($propietario) > 255){
      	$response->state=false;
		$response->detail="El campo Propietario no puede superar 255 caracteres";
	} elseif ( strlen($correoC) > 255){
      	$response->state=false;
		$response->detail="El campo Correo no puede superar 255 caracteres";
	} elseif ( strlen($telefonoC) > 10){
      	$response->state=false;
		$response->detail="El campo Telefono no puede superar 10 caracteres";
	} elseif ( strlen($leyenda) > 255){
      	$response->state=false;
		$response->detail="El campo Leyenda de Stock no puede superar 255 caracteres";
	} elseif ($nomC == "") {
		$response->state=false;
		$response->detail="El campo Nombre del Comercio no puede estar vacio";
	} elseif ($metaTC == "") {
		$response->state=false;
		$response->detail="El campo Meta Tag Title no puede estar vacio";
	} elseif ($propietario == "") {
		$response->state=false;
		$response->detail="El campo Propietario no puede estar vacio";
	} elseif ($correoC == "") {
		$response->state=false;
		$response->detail="El campo Correo no puede estar vacio";
	} elseif ($telefonoC == "") {
		$response->state=false;
		$response->detail="El campo Telefono no puede estar vacio";
	} elseif ($leyenda == "") {
		$response->state=false;
		$response->detail="El campo Leyenda de Stock no puede estar vacio";
	} elseif (!(comprobar_email($correoC))){
   		$response->state=false;
      	$response->detail = 'El Correo introducido no es valido';
   	} elseif ($iAdmin <= 0) {
   		$response->state=false;
      	$response->detail = 'Los items por página de administración deben ser mayores a 0';
   	} elseif ($iStore <= 0) {
   		$response->state=false;
      	$response->detail = 'Los items por página de la tienda deben ser mayores a 0';
   	} else{
   		$nombreImg = $_FILES['iconT']['name'];
		$tipo = $_FILES['iconT']['type'];
		$size = $_FILES['iconT']['size'];
		$tmp = $_FILES['iconT']['tmp_name'];
		//echo $tipo;
		if ( !($nombreImg == "")) {
			if ($size <= 5000000) {
				if ($tipo == "image/png" || $tipo == "image/jpg" || $tipo == "image/jpeg" || $tipo == "image/gif" || $tipo == "image/x-icon") {

					$ruta = "../img/iconos/";
					$archivo = $ruta.$nombreImg;
					if (!file_exists($ruta)) {
						mkdir($ruta);
					}

					if (!file_exists($archivo)) {
						move_uploaded_file($tmp, $archivo);
						$subir = "img/iconos/".$nombreImg;
						$sql = "UPDATE config SET nomCom = '$nomC', metaNom = '$metaTC', metaDes = '$metaDesC', metaClave = '$metaClaveC', propietario = '$propietario', direccion = '$direccionC', correo = '$correoC', telefono = '$telefonoC', itemsAdmin = $iAdmin, itemsStore = $iStore, showStock = '$showStock', leyendaStock = '$leyenda', logo = '$subir' WHERE id = 1;";
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
						$subir = "img/iconos/".$nombreImg;
						$sql = "UPDATE config SET nomCom = '$nomC', metaNom = '$metaTC', metaDes = '$metaDesC', metaClave = '$metaClaveC', propietario = '$propietario', direccion = '$direccionC', correo = '$correoC', telefono = '$telefonoC', itemsAdmin = $iAdmin, itemsStore = $iStore, showStock = '$showStock', leyendaStock = '$leyenda', logo = '$subir' WHERE id = 1;";
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
					$response->detail="Solo se adminten imagenes (png, jpg, jpeg, gif, ico)";
				}
			}else{
				$response->state=false;
				$response->detail="El tamaño no puede ser mayor a 5 MB";
			}
		}else{
			$sql = "UPDATE config SET nomCom = '$nomC', metaNom = '$metaTC', metaDes = '$metaDesC', metaClave = '$metaClaveC', propietario = '$propietario', direccion = '$direccionC', correo = '$correoC', telefono = '$telefonoC', itemsAdmin = $iAdmin, itemsStore = $iStore, showStock = '$showStock', leyendaStock = '$leyenda' WHERE id = 1;";
			$resultado = mysqli_query($conexion, $sql);
			if ($resultado) {
				$response->state=true;
			}else{
				$response->state=false;
				$response->detail="Error al actualizar";
			}
		}
   	}

	echo json_encode($response);

   	function comprobar_email($email) {
    	return (filter_var($email, FILTER_VALIDATE_EMAIL)) ? 1 : 0;
	}
?>
<?php 
	require('../ADMIN/require/conexion.php');

	date_default_timezone_set ('America/Mexico_City');
    $fecha = strftime(date('Y')."-".date('m')."-".date('d'));

	$response = new stdClass();
	//$response->state=true;
	$nombres = $_POST['nombres'];
	$ap1 = $_POST['ap1'];
	$ap2 = $_POST['ap2'];
	$correo = $_POST['email'];
	$usuario = $_POST['user'];
	$pass = $_POST['pass'];

	$order   = '"';
	$replace = '&quot;';
	$nombres = str_replace($order, $replace, $nombres);
	$ap1 = str_replace($order, $replace, $ap1);
	$ap2 = str_replace($order, $replace, $ap2);
	$correo = str_replace($order, $replace, $correo);
	$usuario = str_replace($order, $replace, $usuario);
	$pass = str_replace($order, $replace, $pass);

	if (	
	(strpos($nombres, '<') !== false || strpos($nombres, '>') !== false) || 
	(strpos($ap1, '<') !== false || strpos($ap1, '>') !== false) ||
	(strpos($ap2, '<') !== false || strpos($ap2, '>') !== false) ||
	(strpos($usuario, '<') !== false || strpos($usuario, '>') !== false) ||
	(strpos($correo, '<') !== false || strpos($correo, '>') !== false) ||
	(strpos($pass, '<') !== false || strpos($pass, '>') !== false) 
	){
	    $response->state=false;
		$response->detail="No se permiten los caracteres <, >";
	}elseif (strlen($nombres)>255){
      	$response->state=false;
		$response->detail="El campo Nombre(s) no puede superar 255 caracteres";
   }elseif (strlen($ap1)>255){
      	$response->state=false;
		$response->detail="El campo Primer Apellido no puede superar 255 caracteres";
   }elseif (strlen($ap2)>255){
      	$response->state=false;
		$response->detail="El campo Segundo Apellido no puede superar 255 caracteres";
   }elseif (strlen($usuario)>255){
      	$response->state=false;
		$response->detail="El campo Usuario no puede superar 255 caracteres";
   }elseif (strlen($correo)>255){
      	$response->state=false;
		$response->detail="El campo Correo no puede superar 255 caracteres";
   }elseif (strlen($pass)>255){
      	$response->state=false;
		$response->detail="El campo Correo no puede superar 255 caracteres";
   }elseif ($nombres == "") {
		$response->state=false;
		$response->detail="El campo Nombre(s) no puede estar vacio";
	}elseif ($ap1 == "") {
		$response->state=false;
		$response->detail="El campo Primer Apellido no puede estar vacio";
	}elseif ($usuario == "") {
		$response->state=false;
		$response->detail="El campo Usuario no puede estar vacio";
	}elseif ($correo == "") {
		$response->state=false;
		$response->detail="El campo Correo no puede estar vacio";
	}elseif ($pass == "") {
		$response->state=false;
		$response->detail="El campo Contraseña no puede estar vacio";
	}elseif (!(comprobar_email($correo))){
   		$response->state=false;
      	$response->detail = 'El Correo introducido no es valido';
   }else{
		$usuarios = mysqli_query($conexion, "SELECT COUNT(*) as totalUsu FROM usuarios WHERE usuario = '$usuario'");
		$resUsu = mysqli_fetch_assoc($usuarios);
		$numUsu = $resUsu['totalUsu'];

		$correos = mysqli_query($conexion, "SELECT COUNT(*) as totalCor FROM usuarios WHERE correo = '$correo'");
		$resCor = mysqli_fetch_assoc($correos);
		$numCor = $resCor['totalCor'];

		if ($numUsu == 0) {
			if ($numCor == 0) {
				$passC = md5($pass);
				$sql = "INSERT INTO usuarios VALUES (null, '$nombres', '$ap1', '$ap2', '$usuario', '$correo', '$passC', 2, 'img/predeterminado.png', '$fecha', 1)";
				$resultado = mysqli_query($conexion, $sql);
				if ($resultado) {
					$response->state=true;
				}else{
					$response->state=false;
					//$response->detail="Error al registrar";
				}
			}else{
				$response->state=false;
				$response->detail="El correo ya existe";
			}			
		}else{
			$response->state=false;
			$response->detail="El usuario ya existe";		
		}
	}
	
	echo json_encode($response);



function comprobar_email($email) {
    return (filter_var($email, FILTER_VALIDATE_EMAIL)) ? 1 : 0;
}

?>
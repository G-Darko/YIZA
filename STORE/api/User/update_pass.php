<?php 
	require('../../ADMIN/require/conexion.php');
	require '../../require/session_start.php';
	$response = new stdClass();
	//$response->state=true;

		$sql_c = "SELECT pass FROM usuarios WHERE id_usu = $id_usu";
		$resultado = $conexion->query($sql_c);
		$num = $resultado->num_rows;
		if ($num>0) {
			$row = $resultado->fetch_assoc();
			$passBD = $row['pass'];
			$passC = $passBD;
			$pass = $_POST['pass'];
			$npass = $_POST['npass'];
			$cnpass = $_POST['cnpass'];
			$pass = md5($pass);
			if ($pass == $passC) {
				if (strlen($npass)>255){
      				$response->state=false;
					$response->detail="La nueva contraseña no puede superar 255 caracteres";
   				}else{
   					if ((strpos($npass, '<') !== false || strpos($npass, '>') !== false) ){
					    $response->state=false;
						$response->detail="No se permiten los caracteres <, >";
					}else{

						if ($npass == "") {
							$response->state=false;
							$response->detail="La nueva contraseña no puede estar vacia";
						}else{
							if ($npass == $cnpass) {
								$npass = md5($npass);
								$sql = "UPDATE usuarios SET pass = '$npass' WHERE id_usu = $id_usu" ;
								$resultado = mysqli_query($conexion, $sql);
								if ($resultado) {
									$response->state=true;
								}else{
									$response->state=false;
									$response->detail="Error a actualizar";
								}
							}else{
								$response->state=false;
								$response->detail="Las contraseñas deben ser iguales";
							}
						}
					}
   				}
			}else{
				$response->state=false;
				//$response->detail="La contraseña es incorrecta";
				$response->detail="La contraseña es incorrecta";
			}
		}

	echo json_encode($response);

?>
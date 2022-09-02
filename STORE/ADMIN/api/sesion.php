<?php 
	require('../require/conexion.php');
	session_start();
	$response = new stdClass();

		$usu = $_POST['usu'];
		$contra = $_POST['contra'];
		if ($usu == "") {
			$response->state=false;
			$response->detail="Se requiere el usuario";
		}elseif ($contra == "") {
			$response->state=false;
			$response->detail="Se requiere la contraseña";
		}else{

			//$sql = "SELECT * from usuarios where id_rol = 1 AND usuario = '$usu' OR id_rol = 1 AND correo = '$usu'";
			$sql = "SELECT * from usuarios where usuario = '$usu' or correo = '$usu' ";
			$resultado = $conexion->query($sql);
			$num = $resultado->num_rows;
			if ($num>0) {
				$row = $resultado->fetch_assoc();
				$passBD = $row['pass'];
				$id_rol = $row['id_rol'];
				$status = $row['id_statusUsu'];
				$passC = md5($contra);
				if ($id_rol == 1) {
					if ($status == 1) {
						if ($passBD == $passC) {
							$response->state=true;
							$_SESSION['id'] = $row['id_usu'];
							$_SESSION['nombre'] = $row['nombres'];
							$_SESSION['usuario'] = $row['usuario'];
							$_SESSION['correo'] = $row['correo'];
							$_SESSION['rol'] = $row['id_rol'];
							$_SESSION['img'] = $row['img'];
							$_SESSION['contra'] = $row['pass'];
							//header("Location: ../dashboard.php");
						}else{
							$response->state=false;
							$response->detail="La contraseña es incorrecta";
						}
					}else{
						$response->state=false;
						$response->detail="La usuario esta deshabilitado";
					}
				}else{
					$response->state=false;
					$response->detail="El usuario no es adminstrador";
				}
			}else{
				$response->state=false;
				$response->detail="El usuario no existe";
			}
		}
	
	echo json_encode($response);
?>
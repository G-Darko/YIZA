<?php 
	require '../../ADMIN/require/conexion.php';
	require '../../require/session_start.php';
	$response = new stdClass();
	//$response->state=true;

	if (!isset($_SESSION['id_c'])) {
		$response->state=false;
		$response->detail="Inicia Sesión para poder agregar productos en el carrito";
		$response->sesion=true;
	}else{
		$id_prod = $_POST['id_prod'];
		$cantidad = $_POST['cantidad'];
		$stock = $_POST['stock'];

		if ($cantidad <= 0) {
			$response->state=false;
			$response->detail="La cantidad debe ser mayor o igual a 1";
		}else{
			if ($cantidad > $stock) {
				$response->state=false;
				$response->detail="La cantidad de disponibilidad es: $stock";
			}else{
				$sqlC = "SELECT * FROM carrito WHERE id_usu = '$id_usu' AND id_prod = '$id_prod'";

				$resultado = $conexion->query($sqlC);
				$num = $resultado->num_rows;
				$row = $resultado->fetch_assoc();
				$cantidadSQL = $row['cantidad'];
				$Ncantidad = $cantidadSQL + $cantidad;

				if ($Ncantidad <= $stock) {
					if ($num == 1) {
						$sql = "UPDATE carrito SET cantidad = $Ncantidad WHERE id_usu = '$id_usu' AND id_prod = '$id_prod'";
					}else{
						$sql = "INSERT INTO carrito VALUES (null, $id_prod, $id_usu, $cantidad)";
					}

					$res = mysqli_query($conexion, $sql);

					if ($res) {
						$response->state=true;
					}else{
						$response->state=false;
						$response->detail="Error al agregar en el carrito";
					}
				}else{
					$response->state=false;
					$response->detail="Has superado la disponibilidad";
				}

			}
		}
	}

	

	echo json_encode($response);
?>
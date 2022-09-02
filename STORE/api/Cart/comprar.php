<?php 
	require '../../ADMIN/require/conexion.php';
	require '../../require/session_start.php';
	$response = new stdClass();
	//$response->state=true; 

	date_default_timezone_set ('America/Mexico_City');
	//.' '.date('h').':'.date('i').':'.date('s')
    $fecha = strftime( date('Y')."-".date('m')."-".date('d') );

	$correo = $_POST['swal-correo'];
	$pass = md5($_POST['swal-pass']);

	$sql = "SELECT * FROM usuarios WHERE id_usu = $id_usu";
	$resultado = $conexion->query($sql);
	$row = $resultado->fetch_assoc();

	$sqlCart = "SELECT * FROM carrito WHERE id_usu = $id_usu";
	$resCart = mysqli_query($conexion, $sqlCart);

	$sqlDir = "SELECT * FROM direccion WHERE id_usu = $id_usu";
	$resDir = $conexion->query($sqlDir);
	$rowDir = $resDir->fetch_assoc();

	$id_dir = $rowDir['id_dir'];

	if ($correo == '') {
		$response->state=false;
		$response->detail='El correo o usuario no puede estar vacio';  
	} elseif ($pass == '') {
		$response->state=false;
		$response->detail='La contraseña no puede estar vacia';  
	} else{

		if ($correo == $row['correo'] || $correo == $row['usuario']) {
			if ($pass == $row['pass']) {
				while ($rowCart = mysqli_fetch_assoc($resCart)) {
					$id_cart = $rowCart['id_cart'];
					$id_prod = $rowCart['id_prod'];
					$cantidad = $rowCart['cantidad'];
					$sqlProd = "SELECT * FROM productos WHERE id_prod = $id_prod";
					$resProd = mysqli_query($conexion, $sqlProd);

					$sqlPed = "SELECT * FROM pedidos WHERE id_usu = $id_usu AND id_prod = $id_prod AND id_staTusPed = 2";

					$resPED = $conexion->query($sqlPed);
					$num = $resPED->num_rows;
					$rowP = $resPED->fetch_assoc();
					$cantidadSQL = $rowP['cantidad'];
					$pagoSQL = $rowP['pago'];
					$id_ped = $rowP['id_ped'];
					$Ncantidad = $cantidadSQL + $cantidad;
						

					while ($rowProd = mysqli_fetch_assoc($resProd)) {
						$precio = $rowProd['precio'];
						$pago = $cantidad * $precio;
						$Npago = $pagoSQL + $pago;
						
						if ($num == 1) {
							$sqlInsert = "UPDATE pedidos SET cantidad = $Ncantidad, pago = $Npago, fecha = '$fecha' WHERE id_ped = $id_ped";
						}else{
							$sqlInsert = "INSERT INTO pedidos VALUES (null, $id_usu, $id_dir, $id_prod, 2, $pago, $cantidad, '$fecha')";
						}
						$resInsert = mysqli_query($conexion, $sqlInsert);
						if ($resInsert) {
							$sqlDel = "DELETE FROM carrito WHERE id_cart = $id_cart";
							$resDel = mysqli_query($conexion, $sqlDel);
							if ($resDel) {
								$response->state=true;
							}else{
								$response->state=false;
								$response->detail='Error al comprar (Del cart)';
							}
						}else{
							$response->state=false;
							$response->detail='Error al comprar'; 
						}
					}
					

					

				}
			}else{
				$response->state=false;
				$response->detail='La contraseña es incorrecta';  
			}
		}else{
			$response->state=false;
			$response->detail='El correo o usuario ingresado no es el tuyo';  
		}
	}


	echo json_encode($response);
?>
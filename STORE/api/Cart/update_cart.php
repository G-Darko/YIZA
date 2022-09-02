<?php 
	require '../../ADMIN/require/conexion.php';
	require '../../require/session_start.php';
	$response = new stdClass();
	//$response->state=true;

		$id_prod = $_POST['id_prod'];
		$id_cart = $_POST['id_cart'];
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

				$sql = "UPDATE carrito SET cantidad = $cantidad WHERE id_usu = '$id_usu' AND id_prod = '$id_prod'";
				
				$resultado = mysqli_query($conexion, $sql);

				if ($resultado) {
					$response->state=true;
				}else{
					$response->state=false;
					$response->detail="Error al actualizar el producto del carrito";
				}
			}
		}
	

	

	echo json_encode($response);
?>
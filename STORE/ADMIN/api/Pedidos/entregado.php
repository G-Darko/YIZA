<?php 
	require '../../require/conexion.php';
	$response = new stdClass();
	//$response->state=true;

	$id_ped = $_POST['id_ped'];

	$sql = "UPDATE pedidos SET id_statusPed = 1 WHERE id_ped = $id_ped";
				
	$resultado = mysqli_query($conexion, $sql);


	if ($resultado) {

		$sqlPed = "SELECT * FROM pedidos WHERE id_ped = $id_ped";
		$resPED = $conexion->query($sqlPed);
		$rowPed = $resPED->fetch_assoc();
		$cantidad = $rowPed['cantidad'];
		$id_prod = $rowPed['id_prod'];

		$sqlProd = "SELECT * FROM productos WHERE id_prod = $id_prod";
		$resProd = $conexion->query($sqlProd);
		$rowProd = $resProd->fetch_assoc();
		$stock = $rowProd['stock'];

		$nStock = $stock - $cantidad;

			$sqlUp = "UPDATE productos SET stock = $nStock WHERE id_prod = $id_prod";
				
			$resUp = mysqli_query($conexion, $sqlUp);
			if ($resUp) {
				$response->state=true;
			}else{
				$response->state=false;
				$response->detail="Error al entregar el pedido";
			}
	}else{
		$response->state=false;
		$response->detail="Error al entregar el pedido";
	}
			

	

	echo json_encode($response);
?>
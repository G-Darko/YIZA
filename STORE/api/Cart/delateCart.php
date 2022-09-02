<?php 
	require '../../ADMIN/require/conexion.php';
	require '../../require/session_start.php';
	$response = new stdClass();
	//$response->state=true;

		$id_prod = $_POST['id_prod'];
		$id_cart = $_POST['id_cart'];


		$sql = "DELETE FROM carrito WHERE id_usu = '$id_usu' AND id_prod = '$id_prod'";
				
		$resultado = mysqli_query($conexion, $sql);

		if ($resultado) {
			$response->state=true;
		}else{
			$response->state=false;
			$response->detail="Error al eliminar el producto del carrito";
		}
	
	

	

	echo json_encode($response);
?>
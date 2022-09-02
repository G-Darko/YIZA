<?php 
	require '../../ADMIN/require/conexion.php';
	require '../../require/session_start.php';
	$response = new stdClass();
	//$response->state=true; 

	$sqlNUM = mysqli_query($conexion, "SELECT COUNT(*) AS num FROM direccion WHERE id_usu = $id_usu");
	$resT = mysqli_fetch_assoc($sqlNUM);
	$num = $resT['num'];

	if ($num == 0) {
		$response->state=false;
	}else{
		$sql = "SELECT * FROM direccion WHERE id_usu = $id_usu";
		$resultado = $conexion->query($sql);
		$row = $resultado->fetch_assoc();

		if ($row['no_interior'] != "") {
			$nix = ', '.$row['no_interior'];
		}else{
			$nix = '';
		}
		$id = $row['id_estados'];
		$sqlE = "SELECT * FROM estados WHERE id_estados = $id";
		$resultadoE = $conexion->query($sqlE);
		$rowE = $resultadoE->fetch_assoc();
		$estado = $rowE['nombre'];

		$direccion = $row['calle'].", ".$row['no_exterior'].$nix.", ". $row['colonia'].", ". $row['cod_postal'].", ". $row['municipio'].", ". $estado;

		$response->state=true;
		$response->dir = $direccion;
	}

	echo json_encode($response);
?>
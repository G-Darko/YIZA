<?php 
	$response = new stdClass();
	//$response->state=true;
	$path = $_POST['path'];

	if (unlink('../../'.$path)) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="Error al subir";
	}
	echo json_encode($response);
?>
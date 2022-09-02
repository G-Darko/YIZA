<?php  
	//crear variables conexion
	$servername="localhost";
	$bd="yiza";
	$username="root";
	$password="";

	$response = new stdClass();
	error_reporting(0); //ocultar o mostrar los errores 
	//crear la conexion

	$conexion=mysqli_connect($servername,$username,$password,$bd);
	$msgCon="";
	//validar nuestra conexion.
	if (!$conexion) {
		$msgCon= die("Conexion Fallida.." . mysqli_connect_error ());
	}
	else {
		$msgCon= "Se conecto correctamente la base de datos";
	}
	//echo $msgCon;
?>
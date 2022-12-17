<?php  
	//crear variables conexion
	//$servername="sql5.freesqldatabase.com";
	//$bd="sql5516956";
	//$username="sql5516956";
	//$password="jBXmc7yHJ8";
	
	$servername="sql304.epizy.com";
	$bd="epiz_33215016_yiza";
	$username="epiz_33215016";
	$password="hEzLy5XbpT3uL7";

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

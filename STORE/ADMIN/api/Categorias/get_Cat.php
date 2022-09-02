<?php 
	require '../../require/conexion.php';
	$response = new stdClass();

	$id_cat = $_POST['id_cat'];

	$sql = "SELECT * FROM categorias where id_cat = $id_cat";
	$res = mysqli_query($conexion, $sql);
	$row = mysqli_fetch_assoc($res);
	$obj = new stdClass();


	$nombre = $row['nombre'];
	$des = $row['descripcion'];
	$tMeta = $row['metaT'];
	$desMeta = $row['metaDes'];
	$clave = $row['metaClave'];

	$order   = '&quot;';
	$replace = '"';
	$nombre = str_replace($order, $replace, $nombre);
	$des = str_replace($order, $replace, $des);
	$tMeta = str_replace($order, $replace, $tMeta);
	$desMeta = str_replace($order, $replace, $desMeta);
	$clave = str_replace($order, $replace, $clave);

	$obj->nombre = $nombre;
	$obj->des = $des;
	$obj->tMeta = $tMeta;
	$obj->desMeta = $desMeta;
	$obj->clave = $clave;
	$obj->status = $row['id_statusCat'];

	$sqlP = "SELECT id_padre FROM cPadre where id_cat = $id_cat";
	$resP = mysqli_query($conexion, $sqlP);
	$rowP = mysqli_fetch_assoc($resP);

	$obj->padre = $rowP['id_padre'];

	$response->cat=$obj;

	echo json_encode($response);
?>
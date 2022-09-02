<?php 
	require '../../require/conexion.php';
	$response = new stdClass();

	$id_prod = $_POST['id_prod'];

	$sql = "SELECT * FROM productos where id_prod = $id_prod";
	$res = mysqli_query($conexion, $sql);
	$row = mysqli_fetch_assoc($res);
	$obj = new stdClass();

	$nombre = $row['nombre'];
	$des = $row['des'];
	$tMeta = $row['metaT'];
	$desMeta = $row['metaDes'];
	$clave = $row['metaClave'];
	$modelo = $row['modelo'];
	$sku = $row['sku'];

	$order   = '&quot;';
	$replace = '"';
	$nombre = str_replace($order, $replace, $nombre);
	$des = str_replace($order, $replace, $des);
	$tMeta = str_replace($order, $replace, $tMeta);
	$desMeta = str_replace($order, $replace, $desMeta);
	$clave = str_replace($order, $replace, $clave);
	$modelo = str_replace($order, $replace, $modelo);
	$sku = str_replace($order, $replace, $sku);

	$obj->nombre = $nombre;
	$obj->des = $des;
	$obj->tMeta = $tMeta;
	$obj->desMeta = $desMeta;
	$obj->clave = $clave;
	$obj->modelo = $modelo;
	$obj->sku = $sku;
	$obj->precio = $row['precio'];
	$obj->stock = $row['stock'];
	$obj->status = $row['id_statusProd'];
	$obj->id_mar = $row['id_mar'];
	$obj->id_cat = $row['id_cat'];
	$obj->img = $row['img'];

	$response->prod=$obj;

	echo json_encode($response);
?>
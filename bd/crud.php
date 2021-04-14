<?php


include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$marca = (isset($_POST['marca'])) ? $_POST['marca'] : '';
$contratista = (isset($_POST['contratista'])) ? $_POST['contratista'] : '';
$peso_unitario = (isset($_POST['peso_unitario'])) ? $_POST['peso_unitario'] : '';
$fecha_produccion = (isset($_POST['fecha_produccion'])) ? $_POST['fecha_produccion'] : '';

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';


$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id_tabla = (isset($_POST['id_tabla'])) ? $_POST['id_tabla'] : '';

	switch($opcion){ 
		case 2:        
		$consulta = "UPDATE tabla SET contratista='$contratista', folio='$folio', fecha_produccion='$fecha_produccion' WHERE id_tabla='$id_tabla' ";		
		$resultado = $conexion->prepare($consulta);
		$resultado->execute();        

		$consulta = "SELECT * FROM tabla WHERE id_tabla='$id_tabla' ";       
		$resultado = $conexion->prepare($consulta);
		$resultado->execute();
		$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
		break;
		case 3:        
		$consulta = "UPDATE tabla SET contratista = '', folio = '', fecha_produccion = '' WHERE id_tabla='$id_tabla' ";		
		$resultado = $conexion->prepare($consulta);
		$resultado->execute();                           
		break;
		case 4:    
		$consulta = "SELECT * FROM tabla WHERE ota LIKE '%E2%' AND liberado='SI' ORDER BY fecha_liberado DESC";
		$resultado = $conexion->prepare($consulta);
		$resultado->execute();        
		$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
		break;
	}

print json_encode($data, JSON_UNESCAPED_UNICODE);//envio el array final el formato json a AJAX
$conexion=null;
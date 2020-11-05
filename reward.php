<?php

	include("includes/connect.php");
	include("includes/functions.php");	

$uid  = $_POST['uid'];
$esp = callReward($uid);

	$consulta_lista = "update intentos set megusta = 'TRUE' where id_peticion = '".$uid."'";
	echo $consulta_lista;
	$stmt = $pdo->prepare($consulta_lista);
	$stmt->execute();
							
echo 'true';			
?>

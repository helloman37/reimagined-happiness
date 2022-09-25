<?php
	session_start();
	include_once("conexao.php");

	$id = filter_input(INPUT_GET, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);
	$data = date('Y-m-d', strtotime('+31 days'));
	$dia = "31";
	$uso = "0";
	$uso_dia = "0";
	$estado = "1";

	$result_usuario = "UPDATE usuario SET estado_usuario='$estado', data='$data', dia='$dia', uso='$uso', uso_dia='$uso_dia' WHERE id_usuario='$id'";
	$resultado_usuario = mysqli_query($conexao, $result_usuario);

	if(mysqli_affected_rows($conexao)){
		$_SESSION['msg'] = "";
		header("Location: ../testes");
	}else{
		$_SESSION['msg'] = "";
		header("Location: ../testes");
	}
?>
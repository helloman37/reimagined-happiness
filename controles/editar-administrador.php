<?php
	session_start();
	include_once("conexao.php");
	
	$id                = $_POST['id'];
	$nome_usuario      = $_POST['nome'];
	$senha_usuario     = md5(sha1($_POST['senha'] . "iptv"));
	$login_usuario     = $_POST['login'];
	$estado_usuario    = $_POST['estado'];
	$password          = $_POST['senha'];
	
	$result_usuario    = "UPDATE usuario SET nome_usuario='$nome_usuario', senha_usuario='$senha_usuario', login_usuario='$login_usuario', estado_usuario='$estado_usuario' WHERE id_usuario='$id'";
	$resultado_usuario = mysqli_query($conexao, $result_usuario);
	$result            = "UPDATE passwords SET senha='$password' WHERE id_usuario='$id'";
	mysqli_query($conexao, $result);
	
	if(mysqli_affected_rows($conexao)){
		$_SESSION['msg'] = "";
		header("Location: ../administradores");
	}else{
		$_SESSION['msg'] = "";
		header("Location: ../administradores");
	}
?>
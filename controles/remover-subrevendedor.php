<?php
	session_start();
	include_once("conexao.php");
	
	$id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);
	if(!empty($id_usuario)){
		
		$result_usuario = "DELETE FROM usuario WHERE id_usuario='$id_usuario'";
		$resultado_usuario = mysqli_query($conexao, $result_usuario);
		
		$result_usuario = "DELETE FROM passwords WHERE id_usuario='$id_usuario'";
		$resultado_usuario = mysqli_query($conexao, $result_usuario);
		
		$result_usuario = "DELETE FROM lidas WHERE id_usuario='$id_usuario'";
		$resultado_usuario = mysqli_query($conexao, $result_usuario);

		$result_usuario = "DELETE FROM lista_usuario WHERE id_usuario='$id_usuario'";
		$resultado_usuario = mysqli_query($conexao, $result_usuario);

		$result_usuario = "DELETE FROM logs WHERE id_usuario='$id_usuario'";
		$resultado_usuario = mysqli_query($conexao, $result_usuario);

		$result_usuario = "DELETE FROM mensagens WHERE id_criador='$id_usuario'";
		$resultado_usuario = mysqli_query($conexao, $result_usuario);

		if(mysqli_affected_rows($conexao)){
		$_SESSION['msg'] = "";
			header("Location: ../subrevendedores");
		}else{
			$_SESSION['msg'] = "";
			header("Location: ../subrevendedores");
		}
	}else{	
		$_SESSION['msg'] = "";
		header("Location: ../subrevendedores");
	}
?>
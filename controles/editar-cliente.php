<?php
	session_start();
    require_once('usuarios.php');
	require_once('msg.php');	
	if(isset($_POST['nome']) && isset($_POST['login'])) {
		$id        = $_POST['id'];
		$nome      = $_POST['nome'];
		$senha     = md5(sha1($_POST['senha'] . "iptv"));
		$login     = $_POST['login'];
		$estado    = $_POST['estado'];
		$password  = $_POST['senha'];
		$lista     = $_POST['lista'];
        if ($nome !== "" && $login !== "") {
            if (!editarCliente($id, $nome, $login, $senha, $password, $estado, $lista)) {
                erro();
            }
        } else {
            embranco();
        }
    } else {
        invalido();
    }		
?>
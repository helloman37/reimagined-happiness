<?php
	session_start();
    require_once('usuarios.php');	
	require_once('msg.php');
	if(isset($_POST['nome']) && isset($_POST['login'])) {
		$id       = $_POST['id'];
		$nome     = $_POST['nome'];
		$senha    = md5(sha1($_POST['senha'] . "iptv"));
		$login    = $_POST['login'];
		$estado   = $_POST['estado'];
		$credito  = $_POST['credito'];
		$password = $_POST['senha'];
        if ($nome !== "" && $login !== "") {
			if (isset($_POST['lista'])) {
				$lista = $_POST['lista'];
			} else {
				$lista = [];
			}
            if (!editarVendedor($id, $nome, $login, $senha, $password, $credito, $estado, $lista)) {
                erro();
            }
        } else {
            embranco();
        }
    } else {
        invalido();
    }
?>
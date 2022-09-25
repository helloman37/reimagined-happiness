<?php
	session_start();
    require_once('usuarios.php');
	require_once('msg.php');
    if(isset($_POST['nome']) && isset($_POST['login'])) {
        $nome      = $_POST['nome'];
        $login     = $_POST['login'];
        $password  = $_POST['senha'];
		$senha     = md5(sha1($_POST['senha'] . "iptv"));
		$admin     = 0;
		$vendedor  = 1;
		$estado    = 1;
		$conectado = "0";
		$credito   = $_POST['credito'];
		$acesso    = md5(sha1($_POST['login'] . "iptv"));
		$criador   = $_SESSION['id_usuario'];
		$data      = "";
		$dia       = 0;
		$uso       = 0;
		$uso_dia   = 0;
        if ($nome !== "" && $login !== "") {
			if (isset($_POST['lista'])) {
				$lista = $_POST['lista'];
			} else {
				$lista = [];
			}
            if (!adicionarSubrevendedor($nome, $senha, $password, $login, $admin, $vendedor, $estado, $conectado, $credito, $acesso, $criador, $data, $dia, $uso, $uso_dia, $lista)) {
                erro();
            }
        } else {
            embranco();
        }
    } else {
        invalido();
    }		
?>
<?php
	session_start();
    require_once('usuarios.php');
	require_once('msg.php');
	if(isset($_POST['nome']) && isset($_POST['login'])) {	
		$nome      = $_POST['nome'];
		$senha     = md5(sha1($_POST['senha'] . "iptv"));
		$login     = $_POST['login'];
		$admin     = 0;
		$vendedor  = 0;
		$estado    = 1;
		$conectado = $_POST['conectado'];
		$credito   = "0";
		$acesso    = substr(md5(time()) ,0);
		$criador   = $_SESSION['id_usuario'];
		$data      = date('Y-m-d', strtotime('+31 days'));
		$dia       = 31;
		$uso       = 0;
		$uso_dia   = 0;
		$lista     = $_POST['lista'];
		$password  = $_POST['senha'];
		if ($nome !== "" && $login !== "") {
			if (!adicionarCliente($nome, $senha, $password, $login, $admin, $vendedor, $estado, $conectado, $credito, $acesso, $criador, $data, $dia, $uso, $uso_dia, $lista)) {
				erro();
			}
		}else{
			embranco();
		}
    } else {
        invalido();
    }		
?>
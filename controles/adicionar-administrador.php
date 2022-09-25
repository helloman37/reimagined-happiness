<?php
	session_start();
    require_once('usuarios.php');
    require_once('msg.php');
    if(isset($_POST['nome']) && isset($_POST['login'])){	
		$nome      = $_POST['nome'];
		$senha     = md5(sha1($_POST['senha'] . "iptv"));
		$login     = $_POST['login'];
		$admin     = 1;
		$vendedor  = 0;
		$estado    = 1;
		$conectado = "0";
		$credito   = "0";
		$acesso    = "";
		$criador   = $_SESSION['id_usuario'];
		$data      = "";
		$dia       = 0;
		$uso       = 0;
		$uso_dia   = 0;
		$password  = $_POST['senha'];
		if ($nome !== "" && $login !== "") {
			if(!adicionarAdministrador($nome, $senha, $password, $login, $admin, $vendedor, $estado, $conectado, $credito, $acesso, $criador, $data, $dia, $uso, $uso_dia)){
				erro();
			}
		}else{
			embranco();
		}
    } else {
        invalido();
    }		
?>
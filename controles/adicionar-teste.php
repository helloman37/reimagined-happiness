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
		$conectado = "1";
		$credito   = "0";
		$acesso    = substr(md5(time()) ,0);
		$criador   = $_SESSION['id_usuario'];
		$data      = date('Y-m-d', strtotime('+1 days'));
		$dia       = 1;
		$uso       = 0;
		$uso_dia   = 0;
		$lista     = $_POST['lista'];
		$password  = $_POST['senha'];
        if ($nome !== "" && $login !== "") {
            if (!adicionarTeste($nome, $login, $senha, $password, $admin, $vendedor, $estado, $conectado, $acesso, $criador, $credito,  $data, $dia, $uso, $uso_dia,  $lista)) {
                erro();
            }
        } else {
            embranco();
        }
    } else {
        invalido();
    }			
?>
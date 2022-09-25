<?php
    session_start();
    require_once("usuarios.php");
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $senha = md5(sha1($senha . "iptv"));
    $usuarioB = buscaUsuarioLogin($usuario, $senha);
    if ($usuarioB && ($usuarioB['admin'] === "1" || $usuarioB['vendedor'] === "1")) {
        $_SESSION['id_usuario'] = $usuarioB['id_usuario'];
        $_SESSION['admin'] = $usuarioB['admin'] == "1";
        $_SESSION['vendedor'] = $usuarioB['vendedor'] == "1";
        logarUsuario($usuarioB['nome_usuario']);
        $_SESSION['original'] = $usuarioB['id_usuario'];
        setcookie('original', $usuarioB['id_usuario'], time() + (86400 * 30), "/");
        header("HTTP/1.1 200 OK");
    } else {
        if($usuarioB && $usuarioB['admin'] == "0" && $usuarioB['vendedor'] == "0"){
            header('HTTP/1.0 403 Forbidden');
            echo "Usuário Cliente não tem acesso!";
        }else{
            header('HTTP/1.0 403 Forbidden');
            echo "Usuário ou senha inválida!";
        }       
    }
    if (!is_writable(session_save_path())) {
        echo 'Session path "'.session_save_path().'" is not writable for PHP!'; 
    }
?>
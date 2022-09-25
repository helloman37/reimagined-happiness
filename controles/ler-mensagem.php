<?php
	session_start();
    require_once('mensagens.php');
    if (isset($_GET['id_mensagem'])) {
        $id = $_GET['id_mensagem'];
        if ($id !== "") {
            if (!marcarComoLida($id, $_GET['remover'])) {
                erro();
            }
        } else {
            embranco();
        }
    } else {
        invalido();
    }
?>
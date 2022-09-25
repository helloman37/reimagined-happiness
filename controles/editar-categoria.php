<?php
	session_start();
    require_once('categorias.php');
    require_once('msg.php');
    if (isset($_POST['id']) && isset($_POST['nome'])) {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        if ($nome !== "" && $id !== "") {
            if (!editarCategoria($id, $nome)) {
                erro();
            }
        } else {
            embranco();
        }
    } else {
        invalido();
    }
?>
<?php
	session_start();
    require_once('categorias.php');
    require_once('msg.php');
    if (isset($_POST['nome'])) {
        $nome = $_POST['nome'];
        if ($nome !== "") {
            if (!adicionarCategoria($nome)) {
                erro();
            }
        } else {
            embranco();
        }
    } else {
        invalido();
    }
?>
<?php
	session_start();
    require_once('listas.php');
    require_once('msg.php');
    if (isset($_POST['nome']) && isset($_POST['categoria'])) {
        $nome = $_POST['nome'];
        $categoria = $_POST['categoria'];
        if ($nome !== "" && $categoria !== "") {
            if (!adicionarListaGlobal($nome, $categoria)) {
                erro();
            }
        } else {
            embranco();
        }
    } else {
        invalido();
    }
?>
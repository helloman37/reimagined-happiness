<?php
    require_once('listas.php');

    $idLista = $_POST['idLista'];
    $idUsuario = $_POST['idUsuario'];
    if ($idUsuario) {
        $link= obterLinkLista($idLista, $idUsuario);
        if ($link) { 
            echo $link;
        }
    } else {
        echo "Usuário não informado!";
    }
?>
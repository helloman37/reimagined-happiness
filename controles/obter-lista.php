<?php
    require_once('listas.php');

    $id = $_POST['id'];
    echo obterLista($id);
?>
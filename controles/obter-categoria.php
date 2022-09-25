<?php
    require_once('categorias.php');

    $id = $_POST['id'];
    $links = obterCategoria($id);
    if ($links) { 
        echo json_encode($links);
    }
?>
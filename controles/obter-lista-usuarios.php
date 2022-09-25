<?php
    require_once('listas.php');
    
    $id = $_POST['id'];
    $usuarios= obterListaUsuarios($id);
    if ($usuarios) { 
        echo json_encode($usuarios);
    }
?>
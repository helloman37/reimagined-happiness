<?php
    require_once('links.php');

    $id = $_POST['id'];
    $link = obterLink($id);
    if ($link) { 
        echo json_encode($link);
    }
?>
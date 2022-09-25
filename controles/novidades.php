<?php
    require_once("conexao.php");

    function listarNovidades() {
        $novidades = array();
        global $conexao;
        session_start();
        $query = "select * from link LIMIT 5";
        if($_SESSION['admin']){
            $query = "select * from link order by id_link DESC limit 5";
        }
        $resultado = mysqli_query($conexao, $query);
        while($novidade = mysqli_fetch_assoc($resultado)) {
            array_push($novidades, $novidade);
        }
        return $novidades;
    }
?>
<?php
    require_once('controles/usuarios.php');
    require_once('controles/categorias.php');
    require_once('controles/listas.php');    
    function cors() {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }
    }
    cors();
    $caminho = $_SERVER['REQUEST_URI'];
    $partes = explode("/", $caminho);
    $string = $partes[5];
    $partes = explode(".", $string);
    $antes  = $partes[0];
    $result  = "SELECT link_link from link WHERE id_link = '$antes' limit 1";
    $results = mysqli_query($conexao, $result);
    $dados   = mysqli_fetch_assoc($results);
    $link    = $dados['link_link'];
    header("Content-Type: application/x-mpegurl");
    header("Location: ".$link."");
?>
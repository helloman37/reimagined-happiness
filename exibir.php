<?php
function cors() {

    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400'); // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }
}
cors();
require_once('controles/usuarios.php');
require_once('controles/categorias.php');
require_once('controles/listas.php');

if ($_GET["tipo"] == "m3u_plus") {$tipo = "1";} else {$tipo = "2";}
if (isset($_GET["usuario"]) && isset($_GET["lista"])) {
    $tipo1 = $tipo;
    $tipo2 = "1";
    $usuario = $_GET["usuario"];
    $idlista = $_GET["lista"];
	
    if ($usuario !== "" && $idlista !== "") {
        $lista = acessoLista($usuario, $idlista);
        if ($lista) {
            if ($lista['global'] == 0) {
                echo $lista['lista'];
            } else {
                $links = listaGlobal($idlista);
                if ($links) {
                    echo "". header('Content-Disposition: attachment; filename='.$_GET['usuario'].'.m3u') ."";
                    echo "#EXTM3U";
                    foreach($links as $link) {
                    if($tipo1 <= $tipo2){
                    echo "
#EXTINF:-1 type=\"video\" tvg-id=\"{$link['nome_link']}\" tvg-name=\"{$link['nome_link']}\" tvg-logo=\"{$link['logo']}\" group-title=\"{$link['nome']}\",{$link['nome_link']}
" . preg_replace('/exibir.php.*/', '', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ."video.php?acesso={$link['acessoLink']}&usuario=$usuario";
                    }else{
                    echo "
#EXTINF:-1,{$link['nome_link']}
" . preg_replace('/exibir.php.*/', '', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ."video.php?acesso={$link['acessoLink']}&usuario=$usuario";
					}
                    }
                }
            }
        } else {
            header("HTTP/1.0 404 Not Found");
        }
    } else {
        header("HTTP/1.0 404 Not Found");
    }
} else {
    header("HTTP/1.0 404 Not Found");
}
?>
<?php
$acesso = $_GET['usuario'];
$result = "SELECT * FROM usuario WHERE acesso LIKE '%$acesso%' limit 1";
$usuarios = mysqli_query($conexao, $result);
while($usuario = mysqli_fetch_array($usuarios)){
$hoje = date('Y-m-d');
$data = $usuario['data'];}
$a = explode("-","$data");
$b = explode("-","$hoje");
$antiga= mktime(0, 0, 0, $b[1], $b[2], $b[0]);
$atual= mktime(0, 0, 0, $a[1], $a[2], $a[0]);
$diferenca= $atual-$antiga;
$datas = floor($diferenca/84600);
$data1 = "1";
$data2 = $datas;
if($data1 <= $data2){
echo "";
} else {
$acesso = $_GET['usuario'];
$estado = "0";
$result = "UPDATE usuario SET estado_usuario='$estado' WHERE acesso='$acesso'";
$atualiza = mysqli_query($conexao, $result);}
?>
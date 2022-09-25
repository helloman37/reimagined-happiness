<?php
// DADOS DA HOSPEDAGEM
$endereco = "localhost"; // aqui você coloca host mysql
$usuario = "sattvh21_xtreamservernovo"; // aqui você coloca nome de usuário mysql
$senha = "ffwdy&yBCWQ{"; // aqui você coloca senha mysql
$banco = "sattvh21_xtreamserve-4.9"; // aqui você coloca banco de dados mysql

// CONFIGURAÇÃO PAINEL
$nome = "XtreamServer IPTV 4.9"; // aqui você coloca nome da empresa
$copy = "XtreamServer IPTV 4.9"; // aqui você coloca copyright da empresa
$img = "img/logo.png"; // aqui você coloca logotipo da empresa

// HORA PAINEL
date_default_timezone_set('America/Sao_Paulo');

// DATA PAINEL
$t = date('d-m-Y');
$dayNum = strtolower(date("d",strtotime($t)));
$dayNum = intval($dayNum);

// CONEXÃO PAINEL
if($endereco == "" || $usuario == "" || $banco == ""){
    header("Location: erro");
    die();
}
if (mysqli_connect($endereco, $usuario, $senha, $banco)) {
    $conexao = mysqli_connect($endereco, $usuario, $senha, $banco);
} else {
    header("Location: erro");
    die();
}

// ATUALIZAR DATA DE ACESSO
$q1 = 'UPDATE usuario SET uso = uso + 1, uso_dia = '.$dayNum.' WHERE uso_dia != '.$dayNum.'';
$q2 = 'UPDATE usuario SET estado_usuario = 0, uso = 0 WHERE dia = '.$dayNum.' and uso >= 1';
mysqli_query($conexao, $q1);	
mysqli_query($conexao, $q2);
?>
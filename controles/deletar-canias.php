<?php
session_start();
include_once("conexao.php");

$result_usuario = "DELETE FROM link";
$resultado_usuario = mysqli_query($conexao, $result_usuario);
	
//DELETE FROM funcionarios
//WHERE id = 3;
 
?>
<?php


$host ="localhost";
$password ="";  
$user ="root"; 
$db = "auto-chase";
$conexao = new mysqli($host, $user, $password, $db);


if($conexao->connect_errno){
    echo "Falha ao conectar MySQL".$conexao->connect_error;
    exit();
}

?>

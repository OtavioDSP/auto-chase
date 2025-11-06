<?php


$host ="localhost";
$password ="";  
$user ="root"; 
<<<<<<< HEAD
$db = "autochase";
=======
$db = "auto-chase";
>>>>>>> a344e1aad781c935362c8b03d234a6f8669764b6
$conexao = new mysqli($host, $user, $password, $db);


if($conexao->connect_errno){
    echo "Falha ao conectar MySQL".$conexao->connect_error;
    exit();
}

?>

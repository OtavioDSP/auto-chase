<?php
include_once '../../php/classes/class-modelo.php'; 
include_once '../../config/db/connect.php'; 
$modeloManager = new Modelo(null, null, null, null, null, $conexao);

if($_GET['marca']){
    $marca_id = $_GET['marca'];
    $modelos = $modeloManager->listarModeloPorMarca($marca_id);    
    header('Content-Type: application/json');
    echo json_encode($modelos);
}else{
    echo json_encode([]);
}

?>
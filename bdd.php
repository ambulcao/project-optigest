<?php 

$dbHost = "localhost";
$dbName = "optigest"; 
$dbUser = "root";  
$dbPassword = ""; 

try {
    $db = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPassword);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //echo "Conexão com o banco de dados Optigest estabelecida com sucesso!";
} catch (PDOException $e) {
    //echo "Erro ao conectar com o banco de dados Optigest: " . $e->getMessage();
}

//$db = null;




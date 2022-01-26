<?php

//on mode prod il faut désactiver les erreurs et activer le log  des erreurs dans le fichier "PHP.ini"
/*
    display_errors = off
    log_errors = on    
 */

 //pour une quel que page
    /*
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestionvente";
$charset="utf8mb4";
$dns="mysql:host=$servername;dbname=$dbname;charset=$charset";
$options =[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,   //PDO affiche mois les erreurs dans les exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false   //permet de sécuriser l'execution des requetes SQL contre injections SQL
];
try {
    $conn = new PDO($dns,$username,$password);

}catch(PDOException $e)
{
    echo $e->getMessage().' '.(int)$e->getCode();
}
?>
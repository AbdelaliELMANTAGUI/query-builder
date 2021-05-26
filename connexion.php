<?php
$host = "localhost";
$db = "mvc-demo";
$user = "dev";
$pass = "";
try{
    $con = new PDO("mysql:host=$host;dbname=$db",$user,$pass);
    echo "PDO connected\n";
}
catch(PDOException $e){
    print_r($e);
}
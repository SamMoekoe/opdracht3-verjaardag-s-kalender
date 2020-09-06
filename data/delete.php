<?php

header("../index.php");

$servername = 'localhost';
$database = 'kalender';
$username = 'root';
$password = '';
try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
    try {
        $stmt = $conn->prepare("DELETE FROM `verjaardagen` WHERE id=:id");
        $stmt->bindParam(":id", $_GET["id"]);
        $stmt->execute();
        header('location: ../index.php');
    }
    catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
?>
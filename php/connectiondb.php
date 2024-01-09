<?php

$dbHost = 'localhost';
$dbUser = 'tracker';
$dbPassword = 'tracker';
$dbName = 'tracker';

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Conection error: " . $e->getMessage());
}

?>
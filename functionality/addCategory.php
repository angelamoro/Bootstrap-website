<?php

require_once(__DIR__ . '/connectiondb.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_user = $_SESSION['id_user'];
    $name = $_POST["name"];
    $type = $_POST["type"];

    try {
        $sql2 = "INSERT INTO tracker.categories (name, type, global, id_user) 
                 VALUES (:name, :type, 0, :id_user)";

        $stmt1 = $pdo->prepare($sql2);
        $stmt1->bindParam(':name', $name);
        $stmt1->bindParam(':type', $type);
        $stmt1->bindParam(':id_user', $id_user);
        $stmt1->execute();

        echo '<script>window.location.href="../visuals/categories.php";</script>';

    } catch (PDOException $e) {
        echo 'Error occurred: ' . $e->getMessage();
    }
}

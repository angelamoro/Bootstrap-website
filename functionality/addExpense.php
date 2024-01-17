<?php

require_once(__DIR__ . '/connectiondb.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_user = $_SESSION['id_user'];
    $date = date("Y-m-d", strtotime($_POST["date"]));
    $category = $_POST["category"];
    $description = $_POST["description"];
    $amount = (int)$_POST["amount"];

    try {
        $sql2 = "INSERT INTO tracker.transactions (type, id_category, amount, date, description, id_user) 
                 VALUES ('Expense', :id_category, :amount, :date, :description, :id_user)";

        $stmt1 = $pdo->prepare($sql2);
        $stmt1->bindParam(':id_category', $category);
        $stmt1->bindParam(':amount', $amount);
        $stmt1->bindParam(':date', $date);
        $stmt1->bindParam(':description', $description);
        $stmt1->bindParam(':id_user', $id_user);
        $stmt1->execute();

        echo '<script>window.location.href="../visuals/dashboard.php";</script>';

    } catch (PDOException $e) {
        echo 'Error occurred: ' . $e->getMessage();
    }
}

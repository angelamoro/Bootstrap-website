<?php

require_once(__DIR__ . '/connectiondb.php');

$id_user = $_SESSION['id_user'];

function totalIncomes($id_user, $pdo)
{
    try {
        $sql = "SELECT SUM(amount) AS total_amount FROM tracker.transactions WHERE id_user = :id_user AND type = 'Income'";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_user', $id_user);

        $stmt->execute();
        $total_amount = $stmt->fetch(PDO::FETCH_ASSOC)['total_amount'];

        return ['total_amount' => (int) $total_amount];
    } catch (PDOException $e) {
        return ['error' => 'Error occurred: ' . $e->getMessage()];
    }
}

// Llamar a la función y obtener los datos
$data = totalIncomes($id_user, $pdo);



?>
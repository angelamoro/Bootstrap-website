<?php
require_once(__DIR__ . '/connectiondb.php');
require_once('../visuals/incomes.php');
$id_user = $_SESSION['id_user'];

$newCategory = $_POST['newCategory'];
$newAmount = $_POST['newAmount'];
$newDate = $_POST['newDate'];
$newDescription = $_POST['newDescription'];


try {
    $stmt = $pdo->prepare("
    UPDATE tracker.transactions
    set
        id_category = :category,
        amount = :amount,
        date = :date,
        description = :description
    where
        id_transaction = :transaction AND type='Income'
    ");
    $stmt->bindParam(':category', $newCategory);
    $stmt->bindParam(':amount', $newAmount);
    $stmt->bindParam(':date', $newDate);
    $stmt->bindParam(':description', $newDescription);
    $stmt->bindParam(':transaction', $id_trans);
    $stmt->execute();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}







?>
<?php
require_once(__DIR__ . '/connectiondb.php');
$id_user = $_SESSION['id_user'];

function getExCategories($id_user, $pdo){
try {
    $sql_select_categories = "SELECT id_category, name FROM tracker.categories WHERE id_user = :id_user AND t.type = 'Expense'";
    $stmt_select_categories = $pdo->prepare($sql_select_categories);

    $expenseCategories = [];

    if ($stmt_select_categories->execute()) {
        $expenseCategories = $stmt_select_categories->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($expenseCategories);
    } else {
        echo json_encode([]); 
    }

} catch (PDOException $e) {
    echo json_encode([]); 
    echo 'Error in the database when fetching income categories: ' . $e->getMessage();
}
}
?>
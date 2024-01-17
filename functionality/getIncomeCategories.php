<?php
require_once(__DIR__ . '/connectiondb.php');
$id_user = $_SESSION['id_user'];

function getInCategories($id_user, $pdo){
try {
    $sql_select_categories = "SELECT id_category, name FROM tracker.categories WHERE type = 'Income' AND (global = 1 OR id_user = :id_user)";
    $stmt_select_categories = $pdo->prepare($sql_select_categories);

    $incomeCategories = [];

    if ($stmt_select_categories->execute()) {
        $incomeCategories = $stmt_select_categories->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($incomeCategories);
    } else {
        echo json_encode([]); 
    }

} catch (PDOException $e) {
    echo json_encode([]); 
    echo 'Error in the database when fetching income categories: ' . $e->getMessage();
}
}
?>
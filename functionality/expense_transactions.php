<?php

require_once(__DIR__ . '/connectiondb.php');

$id_user = $_SESSION['id_user'];

function obtainExpenses($id_user, $pdo)
{
    try {
        $sql_select_expenses = "
        SELECT 
            c.name as category_name, 
            t.amount, 
            t.date, 
            t.description 
        FROM 
            tracker.transactions t 
        JOIN 
            tracker.categories c ON t.id_category = c.id_category
        WHERE
            t.id_user = :id_user AND t.type = 'Expense'
        ORDER BY
            date DESC
        ";

        $stmt_select_expenses = $pdo->prepare($sql_select_expenses);
        $stmt_select_expenses->bindParam(':id_user', $id_user);

        $expenses = [];

        if ($stmt_select_expenses->execute()) {
            $expenses = $stmt_select_expenses->fetchAll(PDO::FETCH_ASSOC);
        }

        return $expenses;
    } catch (PDOException $e) {
        echo 'Error in the database when searching for the expenses: ' . $e->getMessage();
        return [];
    }
}

function groupExpenses($id_user, $pdo)
{
    try {
        $sql_select_expenses = "
        SELECT 
            c.name as category_name, 
            SUM(t.amount) as total_amount 
        FROM 
            tracker.transactions t 
        JOIN 
            tracker.categories c ON t.id_category = c.id_category
        WHERE
            t.id_user = :id_user AND t.type = 'Expense'
        GROUP BY
            category_name";

        $stmt_select_expenses = $pdo->prepare($sql_select_expenses);
        $stmt_select_expenses->bindParam(':id_user', $id_user);

        $expenses = [];

        if ($stmt_select_expenses->execute()) {
            $expenses = $stmt_select_expenses->fetchAll(PDO::FETCH_ASSOC);
        }

        return $expenses;
    } catch (PDOException $e) {
        echo 'Error in the database when searching for the expenses: ' . $e->getMessage();
        return [];
    }
}



$expenses = groupExpenses($id_user, $pdo);


$chartData = [];
$chartData[] = ['Category', 'Amount'];

foreach ($expenses as $expense) {
    $chartData[] = [$expense['category_name'], (int) $expense['total_amount']];
}


$chartDataJSON = json_encode($chartData);


?>
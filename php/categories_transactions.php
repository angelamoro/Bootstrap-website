<?php

require_once(__DIR__ . '/connectiondb.php');

$id_user = $_SESSION['id_user'];

function obtainCategoryExpenses($id_user, $pdo)
{
    try {
        $sql_select_expenses = "
        SELECT 
            type,        
            category, 
        FROM 
            tracker.categories
        WHERE
            id_user = :id_user AND type = 'expense'";

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

function obtainCategoryIncomes($id_user, $pdo)
{
    try {
        $sql_select_incomes = "
        SELECT 
            type,
            name
        FROM 
            tracker.categories
        WHERE
            id_user = :id_user AND global=1 AND type = 'income'";
        $stmt_select_incomes = $pdo->prepare($sql_select_incomes);
        $stmt_select_incomes->bindParam(':id_user', $id_user);

        $incomes = [];

        if ($stmt_select_incomes->execute()) {
            $incomes = $stmt_select_incomes->fetchAll(PDO::FETCH_ASSOC);
        }

        return $incomes;
    } catch (PDOException $e) {
        echo 'Error in the database when searching for the incomes: ' . $e->getMessage();
        return [];
    }
}

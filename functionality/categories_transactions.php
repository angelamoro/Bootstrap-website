<?php

require_once(__DIR__ . '/connectiondb.php');

$id_user = $_SESSION['id_user'];

function obtainCategories($id_user, $pdo)
{
    try {
        $sql_select_expenses = "
        SELECT 
            name,    
            type, 
            id_user
        FROM 
            tracker.categories
        WHERE
            id_user = :id_user OR id_user IS NULL
        ORDER BY 
            type, name";

        $stmt_select_expenses = $pdo->prepare($sql_select_expenses);
        $stmt_select_expenses->bindParam(':id_user', $id_user);

        $expenses = [];

        if ($stmt_select_expenses->execute()) {
            $expenses = $stmt_select_expenses->fetchAll(PDO::FETCH_ASSOC);
        }

        return $expenses;
    } catch (PDOException $e) {
        echo 'Error in the database when searching for the categories: ' . $e->getMessage();
        return [];
    }
}



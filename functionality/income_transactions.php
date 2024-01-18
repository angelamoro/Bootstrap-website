<?php

require_once(__DIR__ . '/connectiondb.php');

$id_user = $_SESSION['id_user'];

function obtainIncomes($id_user, $pdo)
{
    try {
        $sql_select_incomes = "
        SELECT 
            t.id_transaction,        
            c.name as category_name, 
                t.amount, 
                t.date, 
                t.description 
            FROM 
                tracker.transactions t 
            JOIN 
                tracker.categories c ON t.id_category = c.id_category
            WHERE
                t.id_user = :id_user AND t.type = 'Income'
            ORDER BY
                date DESC
            ";
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

function groupIncomes($id_user, $pdo)
{
    try {
        $sql_select_incomes = "
        SELECT 
            c.name as category_name, 
            SUM(t.amount) as total_amount
        FROM 
            tracker.transactions t 
        JOIN 
            tracker.categories c ON t.id_category = c.id_category
        WHERE
            t.id_user = :id_user AND t.type = 'Income'
        GROUP BY
            category_name";

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


$incomes = groupIncomes($id_user, $pdo);


$chartData = [];
$chartData[] = ['Category', 'Amount'];

foreach ($incomes as $income) {
    $chartData[] = [$income['category_name'], (int) $income['total_amount']];
}


$chartDataJSONincomes = json_encode($chartData);




?>
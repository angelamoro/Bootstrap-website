<?php

require_once(__DIR__ . '/connectiondb.php');

$id_user = $_SESSION['id_user'];

function obtainTransactions($id_user, $pdo)
{
    try {
        $sql_select_transactions = "
            SELECT 
                t.type, 
                c.name as category_name, 
                t.amount, 
                t.date, 
                t.description 
            FROM 
                tracker.transactions t 
            JOIN 
                tracker.categories c ON t.id_category = c.id_category
            WHERE 
                t.id_user = :id_user
            ORDER BY
                date DESC
        ";

        $stmt_select_transactions = $pdo->prepare($sql_select_transactions);
        $stmt_select_transactions->bindParam(':id_user', $id_user);

        $transactions = [];

        if ($stmt_select_transactions->execute()) {
            $transactions = $stmt_select_transactions->fetchAll(PDO::FETCH_ASSOC);
        }

        return $transactions;
    } catch (PDOException $e) {
        echo 'Error in the database when searching for the transactions: ' . $e->getMessage();
        return [];
    }
}



function addTransaction($id_user, $pdo)
{
    try {
        $sql_select_transactions = "SELECT type, id_categorie, amount, date, description FROM tracker.transactions WHERE id_user = :id_user";
        $stmt_select_transactions = $pdo->prepare($sql_select_transactions);
        $stmt_select_transactions->bindParam(':id_user', $id_user);

        $transactions = [];

        if ($stmt_select_transactions->execute()) {
            $transactions = $stmt_select_transactions->fetchAll(PDO::FETCH_ASSOC);
        }

        return $transactions;
    } catch (PDOException $e) {
        echo 'Error in the database when searching for the incomes: ' . $e->getMessage();
        return [];
    }
}



function groupTransactions($id_user, $pdo)
{
    try {
        $sql_select_incomes = "
            SELECT 
                SUM(amount) as total_income,
                MONTH(date) as transaction_month
            FROM 
                transactions
            WHERE
                id_user = :id_user AND type = 'income'
            GROUP BY
                transaction_month";

        $sql_select_expenses = "
            SELECT 
                SUM(amount) as total_expense,
                MONTH(date) as transaction_month
            FROM 
                transactions
            WHERE
                id_user = :id_user AND type = 'Expense'
            GROUP BY
                transaction_month";

        $stmt_select_incomes = $pdo->prepare($sql_select_incomes);
        $stmt_select_incomes->bindParam(':id_user', $id_user);

        $stmt_select_expenses = $pdo->prepare($sql_select_expenses);
        $stmt_select_expenses->bindParam(':id_user', $id_user);

        $incomes = [];
        $expenses = [];

        if ($stmt_select_incomes->execute()) {
            $incomes = $stmt_select_incomes->fetchAll(PDO::FETCH_ASSOC);
        }

        if ($stmt_select_expenses->execute()) {
            $expenses = $stmt_select_expenses->fetchAll(PDO::FETCH_ASSOC);
        }

        return ['incomes' => $incomes, 'expenses' => $expenses];
    } catch (PDOException $e) {
        echo 'Error in the database when searching for the transactions: ' . $e->getMessage();
        return [];
    }
}


$transactions = groupTransactions($id_user, $pdo);


$chartData = [];
$chartData[] = ['Month', 'Incomes', 'Expenses'];

$incomes = $transactions['incomes'];
$expenses = $transactions['expenses'];


$dataByMonth = array_fill(1, 12, ['Incomes' => 0, 'Expenses' => 0]);


foreach ($incomes as $income) {
    $month = $income['transaction_month'];
    $dataByMonth[$month]['Incomes'] = (int) $income['total_income'];
}

foreach ($expenses as $expense) {
    $month = $expense['transaction_month'];
    $dataByMonth[$month]['Expenses'] = (int) $expense['total_expense'];
}


for ($month = 1; $month <= 12; $month++) {
    $chartData[] = [$month, $dataByMonth[$month]['Incomes'], $dataByMonth[$month]['Expenses']];
}


$chartDataJSONtransactions = json_encode($chartData);



?>
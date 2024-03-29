<?php
session_start();
require_once('../functionality/connectiondb.php');
require_once('../functionality/all_transactions.php');
require_once('../functionality/expense_transactions.php');
require_once('../functionality/income_transactions.php');
require_once('../functionality/total_incomes.php');
require_once('../functionality/getIncomeCategories.php');
require_once('../functionality/getExpenseCategories.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/dashboard.js"></script>

    <!-- Charts -->

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var chartData = <?php echo $chartDataJSONtransactions; ?>;

            var data = google.visualization.arrayToDataTable(chartData);

            var options = {
                curveType: 'function',
                legend: {
                    position: 'bottom'
                },
                animation: "InAndOut",
                series: [{
                    color: 'green',
                    name: 'Income'
                }, {
                    color: 'red',
                    name: 'Expenses'
                }]
            };

            var chart = new google.visualization.LineChart(document.getElementById('transactionsCurve_chart'));

            chart.draw(data, options);
        }
    </script>

    <!-- Expenses by category -->
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawExpensesChart);

        function drawExpensesChart() {
            var chartData = <?php echo $chartDataJSON; ?>;
            var data = google.visualization.arrayToDataTable(chartData);
            var options = {}

            var chart = new google.visualization.PieChart(document.getElementById('expensesPiechart'));

            chart.draw(data, options);
        }
    </script>

    <!-- Incomes by category -->
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawIncomesChart);

        function drawIncomesChart() {
            var chartData = <?php echo $chartDataJSONincomes; ?>;
            var data = google.visualization.arrayToDataTable(chartData);

            var options = {}

            var chart = new google.visualization.PieChart(document.getElementById('incomesPiechart'));

            chart.draw(data, options);
        }
    </script>

</head>

<body class="min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light justify-content-between fixed-top topMenu">
        <div class="container-fluid d-flex justify-content-between align-items-center navigator">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="d-flex align-items-center ">
                <h4 class="mb-0 mr-3">Hello
                    <?php echo $_SESSION['user']; ?>
                </h4>

            </div>

            <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
                <ul class="navbar-nav text-center">
                    <li class="nav-item">
                        <a class="nav-link" href="./dashboard.php"><i class="fas fa-chart-bar"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./transactions.php"><i class="fas fa-exchange-alt"></i>
                            Transactions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./incomes.php"><i class="fas fa-coins"></i> Incomes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./expenses.php"><i class="fas fa-credit-card"></i> Expenses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./categories.php"><i class="fas fa-tags"></i> Categories</a>
                    </li>
                </ul>
            </div>
            <a class="nav-link " href="../functionality/logout.php"><i class="fas fa-sign-out-alt"></i> Sign out</a>
        </div>
    </nav>



    <div class="content-wrapper pt-5 min-vh-100 container">
        <br>
        <h1 class="text-center mt-4 mb-4 tittle"><i class="fas fa-chart-bar"></i> Dashboard</h1>
        <div class="container mt-4">
            <div class="card w-100 pt-5 pb-4">
                <h3 class="text-center"><i class="fas fa-exchange-alt"></i>Transactions by month</h3>
                <div id="transactionsCurve_chart" class="embed-responsive embed-responsive-16by9"></div>
                <h3 class="text-center pt-2">Balance:
                    <?php
                    try {
                        $sql = "SELECT 
                                (SELECT COALESCE(SUM(amount), 0) FROM tracker.transactions WHERE type = 'Income' AND id_user = :id_user) -
                                (SELECT COALESCE(SUM(amount), 0) FROM tracker.transactions WHERE type = 'Expense' AND id_user = :id_user) AS net_total";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':id_user', $id_user);

                        $stmt->execute();
                        $balance = $stmt->fetchColumn();

                        echo $balance;
                    } catch (PDOException $e) {
                        echo 'Error occurred: ' . $e->getMessage();
                    }
                    ?>
                    €
                </h3>
            </div>
        </div>


        <div class="container-fluid mt-4">
            <div class="row">
                <!-- Card 1 -->
                <div class="col-md-6">
                    <div class="card w-100 pt-5 pb-4 d-flex align-items-center justify-content-center">
                        <h3 class="text-center"><i class="fas fa-coins"></i> Incomes by category</h3>
                        <div id="incomesPiechart" class="embed-responsive embed-responsive-16by9"></div>
                        <h3 class="text-center pt-2">Total:
                            <?php
                            try {
                                $sql = "SELECT SUM(amount) AS total_amount FROM tracker.transactions WHERE id_user = :id_user AND type = 'Income'";
                                $stmt = $pdo->prepare($sql);
                                $stmt->bindParam(':id_user', $id_user);

                                $stmt->execute();
                                $totalI = $stmt->fetchColumn();

                                echo $totalI;
                            } catch (PDOException $e) {
                                echo 'Error occurred: ' . $e->getMessage();
                            }
                            ?>
                            €
                        </h3>
                        <!-- floating button -->

                        <div class="btn-container">
                            <button id="show-form" class="floating-btn">+</button>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-md-6">
                    <div class="card w-100 pt-5 pb-4 d-flex align-items-center justify-content-center">
                        <h3 class="text-center"><i class="fas fa-credit-card"></i> Expenses by category</h3>
                        <div id="expensesPiechart" class="embed-responsive embed-responsive-1by1"></div>
                        <h3 class="text-center pt-2">Total:
                            <?php
                            try {
                                $sql = "SELECT SUM(amount) AS total_amount FROM tracker.transactions WHERE id_user = :id_user AND type = 'Expense'";
                                $stmt = $pdo->prepare($sql);
                                $stmt->bindParam(':id_user', $id_user);

                                $stmt->execute();
                                $totalE = $stmt->fetchColumn();

                                echo $totalE;
                            } catch (PDOException $e) {
                                echo 'Error occurred: ' . $e->getMessage();
                            }
                            ?>
                            €
                        </h3>
                        <!-- floating button -->

                        <div class="btn-container">
                            <button id="show-form1" class="floating-btn">+</button>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- form to add incomes -->
    <div class=" popup popupI">
        <div class="close-btn">&times;</div>
        <div class="form">
            <h2>Add Income</h2>
            <form method="post" action="../functionality/addIncome.php">
                <div class="form-element">
                    <label>Date</label>
                    <input type="date" class="form-control" name="date" id="transactionDate">
                </div>
                <div class="form-element">
                    <label>Category:</label>
                    <select name="category" class="form-control">
                        <?php
                        $query = "SELECT id_category, name 
                        FROM tracker.categories 
                        WHERE type = 'Income' AND (global = 1 OR id_user = :id_user)";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(':id_user', $id_user);
                        $stmt->execute();

                        while ($row = $stmt->fetch()) {
                            echo "<option value='" . $row['id_category'] . "'>" . $row['name'] . "</option>";
                        }

                        ?>
                    </select>
                </div>
                <div class="form-element">
                    <label>Description:</label>
                    <input type="text" name="description" class="form-control">
                </div>
                <div class="form-element">
                    <label>Amount</label>
                    <input type="text" name="amount" class="form-control">
                </div>
                <div class="form-element">
                    <button type="submit" class="btn btn-primary">Add transaction</button>
                </div>
                <br>
                <br>
            </form>
        </div>
    </div>


    <!-- form to add expenses -->
    <div class=" popup popupE">
        <div class="close-btn">&times;</div>
        <div class="form">
            <h2>Add Expense</h2>
            <form method="post" action="../functionality/addExpense.php">
                <div class="form-element">
                    <label>Date</label>
                    <input type="date" class="form-control" name="date" id="transactionDate">
                </div>
                <div class="form-element">
                    <label>Category:</label>
                    <select name="category" class="form-control">
                        <?php
                        $query = "SELECT id_category, name 
                        FROM tracker.categories 
                        WHERE type = 'Expense' AND (global = 1 OR id_user = :id_user)";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(':id_user', $id_user);
                        $stmt->execute();

                        while ($row = $stmt->fetch()) {
                            echo "<option value='" . $row['id_category'] . "'>" . $row['name'] . "</option>";
                        }

                        ?>
                    </select>
                </div>
                <div class="form-element">
                    <label>Description:</label>
                    <input type="text" name="description" class="form-control">
                </div>
                <div class="form-element">
                    <label>Amount</label>
                    <input type="text" name="amount" class="form-control">
                </div>
                <div class="form-element">
                    <button type="submit" class="btn btn-primary">Add transaction</button>
                </div>
                <br>
                <br>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light text-center py-2 fixed-bottom">
        <div class="container">
            <p>&copy; 2024 My Kakebo. All rights reserved.</p>
        </div>
    </footer>

    <br>
    <br>
    <br>

</body>

</html>
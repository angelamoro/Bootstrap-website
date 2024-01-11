<?php session_start();
require_once('../php/all_transactions.php');
require_once('../php/expense_transactions.php');
require_once('../php/income_transactions.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>


  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

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
      var options = {
      }

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

      var options = {
      }

      var chart = new google.visualization.PieChart(document.getElementById('incomesPiechart'));

      chart.draw(data, options);
    }
  </script>



</head>

<body style="background-color:black;">
  <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary justify-content-between mb-3 ">
    <div class="container-fluid d-flex">

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <h4>Hello
        <?php echo $_SESSION['user']; ?>
      </h4>
      <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">

        <ul class="navbar-nav text-center">
          <li class="nav-item">
            <a class="nav-link" href="./dashboard.php"><i class="fas fa-chart-bar"></i> Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./transactions.php"><i class="fas fa-exchange-alt"></i> Transactions</a>
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
      <a class="nav-link" href="../php/logout.php"><i class="fas fa-sign-out-alt"></i> Sign out</a>
    </div>
  </nav>
  <center>

      <div class="card" style="width: 80%;">
        <div class="text-center">
          <h3 class="text-center" style="margin: 10px;"><i class="fas fa-exchange-alt"></i>Transactions by month</h3>
        </div>

        <div id="transactionsCurve_chart" class="col-md-12" style="height: 80%;"></div>

        <div class="text-center">
          <a href="./transactions.php" class="btn btn-primary mt-4">View transactions</a>
        </div>

      </div>

      <br>
      <div class="row" style="justify-content: space-evenly">
        <div class="card" style="width: 30%;">
          <h3 class="text-center"><i class="fas fa-credit-card"></i>Expenses by category</h3>
          <div id="expensesPiechart" style="height: 80%;"></div>
          <div class="text-center">
            <a href="./expenses.php" class="btn btn-primary mt-4">View expenses</a>
          </div>
        </div>
        <div class="card col-lg-6" style="width: 30%;">
          <h3 class="text-center"><i class="fas fa-coins"></i>Incomes by category</h3>
          <div class="col-md-12" id="incomesPiechart" style="height: 80%;"></div>
          <div class="text-center">
            <a href="./incomes.php" class="btn btn-primary mt-4">View incomes</a>
          </div>
        </div>
      </div>
    
  </center>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
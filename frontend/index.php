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
  <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- Charts -->

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', { 'packages': ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var chartData = <?php echo $chartDataJSONtransactions; ?>;

      var data = google.visualization.arrayToDataTable(chartData);

      var options = {
        title: 'Transactions by month',
        curveType: 'function',
        legend: { position: 'bottom' },
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
    google.charts.load('current', { 'packages': ['corechart'] });
    google.charts.setOnLoadCallback(drawExpensesChart);

    function drawExpensesChart() {
      var chartData = <?php echo $chartDataJSON; ?>;
      var data = google.visualization.arrayToDataTable(chartData);

      var options = {
        title: 'Expenses by category'
      };

      var chart = new google.visualization.PieChart(document.getElementById('expensesPiechart'));

      chart.draw(data, options);
    }
  </script>

  <!-- Incomes -->
  <script type="text/javascript">
    google.charts.load('current', { 'packages': ['corechart'] });
    google.charts.setOnLoadCallback(drawIncomesChart);

    function drawIncomesChart() {
      var chartData = <?php echo $chartDataJSONincomes; ?>;
      var data = google.visualization.arrayToDataTable(chartData);

      var options = {
        title: 'Incomes by category'
      };

      var chart = new google.visualization.PieChart(document.getElementById('incomesPiechart'));

      chart.draw(data, options);
    }
  </script>



</head>

<body style="background-color: black;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-2 bg-body-tertiary text-center d-none d-lg-block">
        <div class="d-flex flex-column justify-content-between h-100" style="padding: 20px; ">
          <!-- Nombre de usuario -->
          <h4>Hello
            <?php echo $_SESSION['user']; ?>
          </h4>
          <!-- Enlaces a las distintas páginas -->
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active bs-primary-bg-subtle" href="./index.php"><i class="fas fa-chart-bar"></i> Dashboard</a>
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
          <div>
            <a class="nav-link" href="../php/logout.php"><i class="fas fa-sign-out-alt"></i>Sign out</a>
          </div>
        </div>
      </div>
      <div class="col-lg-10">
        <!-- Aquí va el contenido principal de tu aplicación -->
        <h1>AQUI VAN LOS GRAFICOS</h1>
        <div id="transactionsCurve_chart" style="max-width: 100%; height: auto;"></div>
        <div id="expensesPiechart" style="max-width: 100%; height: auto;"></div>
        <div id="incomesPiechart" style="max-width: 100%; height: auto;"></div>

      </div>
    </div>
  </div>
</body>

</html>
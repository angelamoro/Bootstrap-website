<?php session_start();
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
</head>

<body style="background-color: black;">
  <div class="container-fluid" style="height: 100vh;">
    <!-- Contenido principal -->
    <div class="row">
      <!-- Menú lateral -->
      <div class="col-lg-2 bg-body-tertiary text-center d-none d-lg-block" style="height: 100vh;">
        <div class="d-flex flex-column justify-content-between h-100" style="padding: 20px;">
          <!-- Nombre de usuario -->
          <h4 style="color: blueviolet;">Hello
            <?php echo $_SESSION['user']; ?>
          </h4>
          <!-- Enlaces a las distintas páginas -->
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="./index.php"><i class="fas fa-chart-bar"></i> Dashboard</a>
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
        <h1>Incomes</h1>
        <div class="table-responsive">
          <table class="table table-bordered border-primary table-hover table-sm align-middle">
            <thead>
              <tr>
                <th>Category</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Description</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $incomes = obtainIncomes($id_user, $pdo);
              foreach ($incomes as $income) { ?>
                <tr>
                  <td>
                    <?= $income['category_name'] ?>
                  </td>
                  <td>
                    <?= $income['amount'] ?>
                  </td>
                  <td>
                    <?= $income['date'] ?>
                  </td>
                  <td>
                    <?= $income['description'] ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

        </div>


      </div>
    </div>
  </div>
</body>

</html>
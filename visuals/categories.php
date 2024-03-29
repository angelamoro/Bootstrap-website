<?php
session_start();
require_once('../functionality/categories_transactions.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categories</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</head>

<body class="min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light justify-content-between fixed-top topMenu">
        <div class="container-fluid d-flex justify-content-between align-items-center navigator">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
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



    <div class="content-wrapper pt-5 justify-content-between min-vh-100 container">
        <br>
        <h1 class="text-center mt-4 mb-4 tittle"><i class="fas fa-tags"></i> Categories</h1> 
        <div class="table-container conTable">
            <div class="table-responsive mb-5 pb-5">
                <table class="table table-striped mx-auto " style="max-width: fit-content;">
                    <thead class="thead-dark">
                        <tr>
                            <th>Type</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                        $transactions = obtainCategories($id_user, $pdo);
                        $rowsPerPage = 15;
                        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                        $startIndex = ($currentPage - 1) * $rowsPerPage;

                        //Filter transactions for the actual page
                        $transactionsForPage = array_slice($transactions, $startIndex, $rowsPerPage);

                        foreach ($transactionsForPage as $transaction) { ?>
                            <tr>
                                <td>
                                    <?= $transaction['type'] ?>
                                </td>
                                <td>
                                    <?= $transaction['name'] ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>



            <!-- Pagination -->
            <nav aria-label="Page navigation mt-20" class="fixed-bottom pb-5 mb-1 pages">
                <ul class="pagination justify-content-center">
                    <?php
                    //Total number of pages
                    $totalPages = ceil(count($transactions) / $rowsPerPage);

                    //Pagination Links
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo '<li class="page-item ' . ($currentPage == $i ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div> <!-- floating button -->
        <div class="btn-container">
            <button id="show-form" class="">+</button>
        </div>

    <!-- form to add categories -->
    <div class=" popup popupC">
        <div class="close-btn">&times;</div>
        <div class="form">
            <h2>Add Income</h2>
            <form method="post" action="../functionality/addCategory.php">
            <div class="form-element">
                    <label>Name:</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-element">
                    <label>Type:</label>
                    <select name="type" class="form-control">
                        <option>Income</option>
                        <option>Expense</option>
                    </select>
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
    <footer class="bg-dark text-light text-center py-2  fixed-bottom">
        <div class="container">
            <p>&copy; 2024 My Kakebo. All rights reserved.</p>
        </div>
    </footer>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
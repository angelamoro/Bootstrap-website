<?php

require_once('./connectiondb.php');

function obtainUserId($name, $surname, $pdo)
{
    try {
        // Buscar el ID del empleado por name y surname
        $sql_select_id = "SELECT id_user FROM tracker.users WHERE name = :name AND surname = :surname";
        $stmt_select_id = $pdo->prepare($sql_select_id);
        $stmt_select_id->bindParam(':name', $name);
        $stmt_select_id->bindParam(':surname', $surname);

        if ($stmt_select_id->execute() && $stmt_select_id->rowCount() > 0) {
            $row = $stmt_select_id->fetch();
            return $row['id_user'];
        }
    } catch (PDOException $e) {
        echo 'Error in the database when searching for the user ID: ' . $e->getMessage();
        return null;
    }
}

function checkEmail($email, $pdo)
{
    try {
        $sql_select_email = "SELECT COUNT(*) AS count FROM tracker.users WHERE email = :email";
        $stmt_select_email = $pdo->prepare($sql_select_email);
        $stmt_select_email->bindParam(':email', $email);

        if ($stmt_select_email->execute()) {
            $row = $stmt_select_email->fetch(PDO::FETCH_ASSOC);
            return $row['count'] > 0;
        }
    } catch (PDOException $e) {
        echo 'Error in database while checking user email: ' . $e->getMessage();
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (!empty($name) && !empty($surname) && !empty($email) && !empty($hashed_password)) {
        try {
            $id_user = obtainUserId($name, $surname, $pdo);
            $emailExists = checkEmail($email, $pdo);

            if ($id_user === null && !$emailExists) {
                $sql = "INSERT INTO tracker.users (name, surname, email, password)
                VALUES (:name, :surname, :email, :password)";
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':surname', $surname);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashed_password);
            } else {
                echo 'The entered email or user data is already in use';
                exit;
            }

        } catch (Exception $ex) {
            echo 'Error in adding: ' . $ex->getMessage();
            exit;
        }
    } else {
        echo 'Please complete all fields';
        exit;
    }

    $stmt->execute();
    echo '<script>window.location.href="../visuals/login.html";</script>';
}
?>
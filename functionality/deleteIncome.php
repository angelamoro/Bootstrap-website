<?php

require_once(__DIR__ . '/connectiondb.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar el ID de la transacción desde la solicitud POST
    $transactionId = isset($_POST["transactionId"]);

    if ($transactionId !== null) {

        // Sentencia SQL para eliminar la transacción
        $sql = "DELETE FROM tracker.transactions WHERE id_transaction = :transactionId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':transactionId', $transactionId, PDO::PARAM_INT);

        // Ejecutar la sentencia
        $stmt->execute();

        // Comprobar si se realizó la eliminación exitosamente
        $rowCount = $stmt->rowCount();

        if ($rowCount > 0) {
            echo "success"; // La transacción se eliminó con éxito
        } else {
            echo "error"; // No se encontró la transacción o no se pudo eliminar
        }
    }   
}

// Si llegamos aquí, hubo un error en la solicitud
echo "error";
?>
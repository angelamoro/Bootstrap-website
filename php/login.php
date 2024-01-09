<?php

require_once('./connectiondb.php');

$password = $_POST['password'];

class Password
{
    public static function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}


$tabla = "users";

// Recibir los datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Buscar por email
$emailQuery = $pdo->prepare("SELECT * FROM $tabla WHERE email = ?");
$emailQuery->bindParam(1, $email);
$emailQuery->execute();
$emailResult = $emailQuery->fetchAll();

// Verificar si se encontró algún registro con el email
if (count($emailResult) === 0) {
    echo "Incorrect email.";
} else {
    // Comprobar la contraseña
    $hashSaved = $emailResult[0]['password'];
    if (Password::verifyPassword($password, $hashSaved)) {
        // Nombre de usuario encontrado
        $userName = $emailResult[0]['name'];
        $userId = $emailResult[0]['id_user'];

        // Iniciar sesión
        session_start();
        $_SESSION['user'] = $userName;
        $_SESSION['id_user'] = $userId;

        header("Location: ../frontend/index.php");
        exit();
    } else {
        echo "Incorrect password, try again.";
    }
}


?>
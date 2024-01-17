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
$remember = isset($_POST['remember_me']) ? $_POST['remember_me'] : false;

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

        // Si "Remember Me" está marcado, establecer una cookie para mantener la sesión
        if ($remember) {
            $cookie_name = "remember_me_cookie";
            $cookie_value = $userId; // Puedes almacenar el ID del usuario u otra información segura
            $expiration = time() + (86400 * 30); // Ejemplo: cookie válida por 30 días

            // Establecer la cookie
            setcookie($cookie_name, $cookie_value, $expiration, "/");
        }

        echo '<script>window.location.href="../visuals/dashboard.php";</script>';
        exit();
    } else {
        echo "Incorrect password, try again.";
    }
}
?>

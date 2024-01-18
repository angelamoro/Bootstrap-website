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


$email = $_POST['email'];
$password = $_POST['password'];
$remember = isset($_POST['remember_me']) ? $_POST['remember_me'] : false;


$emailQuery = $pdo->prepare("SELECT * FROM $tabla WHERE email = ?");
$emailQuery->bindParam(1, $email);
$emailQuery->execute();
$emailResult = $emailQuery->fetchAll();


if (count($emailResult) === 0) {
    echo "Incorrect email.";
} else {
    
    $hashSaved = $emailResult[0]['password'];
    if (Password::verifyPassword($password, $hashSaved)) {
        
        $userName = $emailResult[0]['name'];
        $userId = $emailResult[0]['id_user'];

        
        session_start();
        $_SESSION['user'] = $userName;
        $_SESSION['id_user'] = $userId;

        
        if ($remember) {
            $cookie_name = "remember_me_cookie";
            $cookie_value = $userId; 
            $expiration = time() + (86400 * 30); 
            
            setcookie($cookie_name, $cookie_value, $expiration, "/");
        }

        echo '<script>window.location.href="../visuals/dashboard.php";</script>';
        exit();
    } else {
        echo "Incorrect password, try again.";
    }
}
?>

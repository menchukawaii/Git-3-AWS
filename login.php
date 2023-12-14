<?php
    $errorLogin = "";
    //Si se accede a la página con un error de login
    if(isset($_GET["errorLogin"])){
        $errorLogin = $_GET["errorLogin"];
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <form method="POST" action="principal.php">
        <h1>Login</h1>
        <span><?php echo $errorLogin; ?></span>
        <input type="text" name="user" placeholder="Usuario Email">
        <input type="password" name="password" placeholder="Clave">
        <button>Login</button>
    </form>


</body>
</html>

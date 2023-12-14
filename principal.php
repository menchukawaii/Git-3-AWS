<?php
    function writePage($username, $userType = ""){
        echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link rel='stylesheet' href='style.css'>
            <title>Principal</title>
        </head>
        <body>
            <h1>Bienvenido $username</h1>
            <nav>
                <ul>
                    <li><a href='ficheros.php?userType=$userType'>Ficheros</a></li>
                    <li><a href='alumnado.php?userType=$userType'>Datos del alumnado</a></li>
                </ul>
                <a href='logout.php'>Log Out</a>
            </nav>
        </body>
        </html>";
    }
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $user = $_POST["user"];
        $clave = $_POST["password"];

        $validateEmailEducastur = "/^[a-z][a-z0-9_]*\@(educastur\.(es|org))$/";
        $validateEmailOther = "/^[a-z][a-z0-9_]*\@([a-z]+\.[a-z]{2,3})$/";

        if($user == "" || $clave == "" || !preg_match($validateEmailOther, $user) ){
            header("Location: login.php?errorLogin=Datos de usario NO válidos");
        }else{
            if($user == "carmengr36@educastur.es" && $clave == "1234"){
                // Accede admin
                $userType = "admin";
                writePage($user, $userType);
            }else if(preg_match($validateEmailOther, $user) && $clave == "1234" && !preg_match($validateEmailEducastur, $user)){
                // Accede invitado, si el correo no es de educastur
                $userType = "invitado";
                writePage($user, $userType);
            }else{
                header("Location: login.php?errorLogin=Contraseña Incorrecta");
            }
        }
    }
    else{//Si se accede a la página sin haber enviado el formulario
        header("Location: login.php");
    }

    
?>
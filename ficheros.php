<?php
    $filesArray = scandir("uploadedFiles");//Array con los archivos ubicados en uploadedFiles
    
    function openHTML(){
        echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link rel='stylesheet' href='style.css'>
            <title>Ficheros</title>
        </head>
        <body>";
    }
    function closeHTML(){
        echo "</body>
        </html>";
    }
    function buttonLogout(){
        echo "<a href='logout.php'>Log Out</a>";
    }
    function showTableFiles($filesArray){
        echo "<h1>Ficheros</h1>
            <table>";
        foreach ($filesArray as $i => $file) {
            // Buena práctica asegurarse de que solo se muestren los archivos reales y no las referencias al propio directorio ni al directorio padre.
            if($file != "." && $file != ".."){
                echo "<tr>
                        <td>$file</td>
                        <td><a href='uploadedFiles/$file' download>Descargar</a></td>
                      </tr>";
            }
        }
        echo "</table>";
    }
    function showFormUploadFiles(){
        echo "<h2>Subir archivos</h2>
        <form method='POST' action='uploadFiles.php' enctype='multipart/form-data'>
            <label for='file'>Selecciona un archivo:</label>
            <input type='file' name='file' id='file'>
            <button>Subir archivo</button>
        </form>";
    }

if(isset($_GET["userType"])){//Si se llega desde la página principal
    $userType = $_GET["userType"];

    if($userType == "admin"){
        openHTML();
        showTableFiles($filesArray);
        showFormUploadFiles();
        buttonLogout();
        closeHTML();
    } 
    else {// invitado
        openHTML();
        showTableFiles($filesArray);
        buttonLogout();
        closeHTML();
    }
}
else if(isset($_GET["uploaded"])){//Si se llega al volver a cargar la página tras subir un archivo
    openHTML();
        showTableFiles($filesArray);
        showFormUploadFiles();
        buttonLogout();
        closeHTML();

}
else{
    header("Location: login.php");
}
?>

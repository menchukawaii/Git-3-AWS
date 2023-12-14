<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $targetDirectory = "uploadedFiles/"; //Directorio donde se subiran los archivos
    $targetFile = $targetDirectory . basename($_FILES["file"]["name"]); //Ruta completa que tendrá el nuevo fichero subido
    $uploadOk = true;

    // Verificar si el archivo ya existe
    if (file_exists($targetFile)) {
        echo "<p>El archivo ya existe.</p>";
        $uploadOk = false;
    }

    // Verificar el tamaño del archivo (debe ser e¡menor de 500000 bytes, 500KB)
    if ($_FILES["file"]["size"] > 500000) { 
        echo "<p>El archivo es demasiado grande.</p>";
        $uploadOk = false;
    }

    // Permitir solo ciertos formatos de archivo
    $allowedExtensions = array("txt", "jpg", "jpeg", "png", "gif");
    $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedExtensions)) {
        echo "<p>Solo se permiten archivos JPG, JPEG, PNG y GIF.</p>";
        $uploadOk = false;
    }

    // Verificar si $uploadOk es false por algún error
    if ($uploadOk == false) {
        echo "<p>No se pudo subir el archivo.</p>";
    } else {
        // Intentar mover el archivo al directorio de carga
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            // Si el archivo se ha subido redirige a ficheros.php 
            header("Location: ficheros.php?uploaded");
            exit();
        } else {
            //Si no se ha subido muestra un mensaje de error
            echo "<p>Hubo un error al subir el archivo.</p>";
        }
    }
} else {
    header("Location: login.php");
}
?>

<?php
function openHTML(){
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='style.css'>
        <title>Alumnado</title>
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

function showTableStudents($students){
    echo "<h1>Alumnado</h1>
        <table>
            <tr>
                <th>Nombre y Apellidos</th>
                <th>Curso</th>
            </tr>";

    foreach ($students as $student) {
        // Divide la cadena de datos del alumno en un array usando el espacio como separador
        $infoStudent = explode(" ", $student);
        // Obtiene el nombre y apellidos del alumno, excluyendo el último elemento que es el curso
        $nombreApellidos = implode(" ", array_slice($infoStudent, 0, count($infoStudent) - 1));
        // Obtiene el ultimo elemento del array
        $curso = end($infoStudent);

        echo "<tr>
                <td>$nombreApellidos</td>
                <td>$curso</td>
            </tr>";
    }

    echo "</table>";
}

function showFormAddStudent(){
    echo "<h2>Formulario para añadir/modificar alumno</h2>
    <form method='POST' action='alumnado.php'>
        <label for='nombreApellidos'>Nombre y Apellidos:</label>
        <input type='text' name='nombreApellidos' id='nombreApellidos' required>
        <label for='curso'>Curso:</label>
        <input type='text' name='curso' id='curso'>
        <button type='submit' name='submit'>Agregar/Modificar</button>
    </form>";
}

function addStudent($students, $nombreApellidos, $curso) {
    $studentExist = false;

    foreach ($students as $key => $student) {
        // Divide la cadena de datos del alumno en un array usando el espacio como separador
        $infoTableStudent = explode(" ", $student);
        // Obtiene el nombre y apellidos del alumno, excluyendo el último elemento que es el curso
        $nombreApellidosTableStudent = implode(
            " ",
            array_slice($infoTableStudent, 0, count($infoTableStudent) - 1)
        );

        if ($nombreApellidos == $nombreApellidosTableStudent) {
            $studentExist = true;
            $index = $key;//Guarda la posicion del elemento del array que coincide con el nuevo nombreApellidos
            break; 
        }
    }

    if (!$studentExist) {//El nombre del alumno NO existe en la tabla
        if(empty($curso)){
            echo "<p>Ha intentado introducir un alumno sin curso</p>";
        }else{
            array_push($students, "$nombreApellidos $curso");
        }
    }
    else{//El nombre del alumno existe en la tabla
        if(empty($curso)){
            //Elimina el alumno con el nombre que se ha introducido
            array_splice($students, $index, 1);
        }else{
            //Remplaza el alumno con mismo nombre por el nuevo alumno con el curso actualizado
            array_splice($students, $index, 1, "$nombreApellidos $curso");
        }
    }

    return $students;
}

// Array  donde cada linea del fichero es un elemento
$students = file("studentsFile.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);//Parámetros para evitar lineas en blanco en el fichero

if (isset($_GET["userType"])) {
    $userType = $_GET["userType"];

    if ($userType == "admin") {
        openHTML();
        showTableStudents($students);
        showFormAddStudent();
        buttonLogout();
        closeHTML();
    } else { // invitado
        openHTML();
        showTableStudents($students);
        buttonLogout();
        closeHTML();
    }
}
else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombreApellidos"])) {// Procesar el formulario para agregar/modificar alumno
    $nombreApellidos = $_POST["nombreApellidos"];
    $curso = $_POST["curso"];
    
    $students = addStudent($students, $nombreApellidos, $curso);
    // Actualizar el archivo de alumnos
    file_put_contents("studentsFile.txt", implode(PHP_EOL, $students));

    openHTML();
    showTableStudents($students);
    showFormAddStudent();
    buttonLogout();
    closeHTML();
}
else {
    header("Location: login.php");
}
?>

<?php
require_once ("db/conexion.php"); 
$db = new Database();
$con = $db ->conectar();
session_start();
?>
<?php
    if ((isset($_POST["MM_insert"]))&&($_POST["MM_insert"]=="formreg"))
    {
        $documento = $_POST['documento'];
        $nombre = $_POST['nombre'];
        $fecha_naci = $_POST['fecha_naci'];
        $telefono= $_POST['telefono'];

        $validar = $con -> prepare ("SELECT * FROM usuarios WHERE documento='$documento'");
        $validar -> execute();
        $fila1 = $validar -> fetch();

        if ($fila1){
            echo '<script> alert ("DOCUMENTO O USUARIO YA EXISTEN // CAMBIELOS//");</script>';
            echo '<script> windows.location= "formulario1.php"</script>';

        }

        else if ($documento=="" || $nombre=="" || $fecha_naci=="" || $telefono=="")
        {
            echo '<script> alert (" EXISTEN DATOS VACIOS");</script>';
            echo '<script> windows.location= "formulario1.php"</script>';
        }

        else
        {
            $insertsql = $con -> prepare("INSERT INTO usuarios (documento,nombre,fecha_naci,telefono) VALUES ('$documento','$nombre', '$fecha_naci', '$telefono')");
            $filaa1 = $insertsql -> execute();
            echo '<script>alert ("Datos registrados exitosamente");</script>';
            echo '<script>windows.location="formulariovacu.php"</script>';
        }

    }

?>


<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <form action="formulario1.php" method="POST">
        <label for="documento">Número de Documento:</label>
        <input type="number" id="documento" name="documento" required><br><br>
        
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>
        
        
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_naci" name="fecha_naci" required><br><br>
        
        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" required><br><br>
        
        <input type="submit" name="validar" " value="Guardar" class="btn btn-info" style="margin-right: 20px;">
        <input type="hidden" name="MM_insert" value="formreg">
    </form>
</body>
</html>
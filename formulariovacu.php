<?php
require_once("db/conexion.php");
$db = new Database();
$con = $db->conectar();
session_start();
?>
<?php
$personas_query = "SELECT documento, nombre FROM usuarios"; // Cambia el nombre de la tabla si es necesario
$personas_result = $con->query($personas_query);
?>
<?php

if ((isset($_POST["MM_insert"]))&&($_POST["MM_insert"]=="formreg"))
    {
        $nombre_vac = $_POST['nom_vac'];
        $fecha_aplic = $_POST['fecha_aplic'];
        $enfermero= $_POST['enfermero'];

        $validar = $con -> prepare ("SELECT * FROM vacuna ");
        $validar -> execute();
        $fila1x = $validar -> fetch();

        if ($fila1x){
            echo '<script> alert ("DOCUMENTO O USUARIO YA EXISTEN // CAMBIELOS//");</script>';
            echo '<script> windows.location= "formulario1.php"</script>';

        }

        else if ($nombre_vac=="" || $fecha_aplic=="" || $enfermero=="")
        {
            echo '<script> alert (" EXISTEN DATOS VACIOS");</script>';
            echo '<script> windows.location= "formulario1.php"</script>';
        }

        else
        {
            $insertsql = $con -> prepare("INSERT INTO vacuna (nom_vac,fecha_aplic,enfermero) VALUES ('$nombre_vac','$fecha_aplic', '$enfermero')");
            $filaax1 = $insertsql -> execute();
            echo '<script>alert ("Datos registrados exitosamente");</script>';
            echo '<script>windows.location="formulariovacu.php"</script>';
        }

    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Vacunación</title>
</head>
<body>
    <h2>Registro de Vacunación</h2>
    <form action="formulariovacu.php" method="POST">

        <label for="nombre_vacuna">Nombre de la Vacuna:</label>
        <input type="text" id="nombre_vacuna" name="nom_vac" required><br><br>

        <label for="fecha_aplicacion">Fecha de Aplicación:</label>
        <input type="date" id="fecha_aplicacion" name="fecha_aplic" required><br><br>

        <label for="enfermero">Enfermero:</label>
        <input type="text" id="enfermero" name="enfermero" required><br><br>

        <label for="documento">Selecciona una persona:</label>
        <select name="documento">
            <?php while ($persona = $personas_result->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?php echo $persona['documento']; ?>"><?php echo $persona['nombre']; ?></option>
            <?php } ?>
        </select><br><br>

        <input type="submit" name="validar" value="Guardar" class="btn btn-info" style="margin-right: 20px;">
        <input type="hidden" name="MM_insert" value="formreg">
    </form>

    <script>
        document.getElementById('fecha_aplicacion').addEventListener('change', function() {
            var fechaAplicacion = new Date(this.value);
            var unAnioDespues = new Date(fechaAplicacion);
            unAnioDespues.setFullYear(unAnioDespues.getFullYear() + 1);
            
            var alerta = "Debe volver a aplicarse la otra dosis el " + unAnioDespues.toLocaleDateString();
            alert(alerta);
        });
    </script>
</body>
</html>
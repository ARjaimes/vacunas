<?php
require_once("db/conexion.php");

try {
    $db = new Database();
    $con = $db->conectar();
    
    $query = "SELECT * FROM vacuna";
    $stmt = $con->prepare($query);
    $stmt->execute();
    
    $vacunas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Vacunación</title>
</head>
<body>
    <table class="table table-dark">
        <thead>
            <tr>
                <th>Documento</th>
                <th>Nombre</th>
                <th>ID de Vacuna</th>
                <th>Nombre de Vacuna</th>
                <th>Fecha de Aplicación</th>
                <th>Próxima Aplicación</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($vacunas as $row) {
                $documento = $row['documento'];
                $nombre = $row['nombre'];
                $id_vacuna = $row['id_vacuna'];
                $nomb_vac = $row['nom_vac'];
                $fecha_apli = $row['fecha_apli'];
                
                $fecha_actual = new DateTime();
                $fecha_proxima = new DateTime($fecha_aplicacion);
                $fecha_proxima->add(new DateInterval('P1Y')); // Suma un año
                
                echo "<tr>";
                echo "<td>$documento</td>";
                echo "<td>$nombre</td>";
                echo "<td>$id_vacuna</td>";
                echo "<td>$nombre_vacuna</td>";
                echo "<td>$fecha_aplicacion</td>";
                echo "<td>" . $fecha_proxima->format('Y-m-d') . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

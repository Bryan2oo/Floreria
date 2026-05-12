<?php
include("../../Model/MAdministrador/MMenuNavAdmin2.php");
include("../../Model/MAdministrador/MBuscar.php");

// Cambiar nombre de clase a algo más general
$modelo = new ProductoModel();
$resultados = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['buscar'])) {
    $buscar = $_POST['buscar'];
    $resultados = $modelo->buscarProducto($buscar);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Public/css/CssAdministrador/stylesNavAdmin.css">
    <link rel="stylesheet" href="../../Public/css/stylesFondo.css">
    <link rel="stylesheet" href="../../Public/css/CssAdministrador/stylesAdminBuscar.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Buscar Producto</h2>
        <form method="POST" class="d-flex">
            <input type="text" name="buscar" class="form-control me-2" placeholder="Ingrese ID o Nombre">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <?php if ($resultados !== null): ?> 
        <div class="mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Descripción</th>
                        <th>Stock</th>
                        <th>Imagen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultados->num_rows > 0) {
                        while ($row = $resultados->fetch_assoc()) {
                            echo "<tr>"
                                . "<td>" . htmlspecialchars($row['id']) . "</td>"
                                . "<td>" . htmlspecialchars($row['tipo']) . "</td>"
                                . "<td>" . htmlspecialchars($row['nombre']) . "</td>"
                                . "<td>$" . htmlspecialchars($row['precio']) . "</td>"
                                . "<td>" . htmlspecialchars($row['descripcion']) . "</td>"
                                . "<td>" . htmlspecialchars($row['stock']) . "</td>"
                                . "<td>";
                                if (!empty($row['imagen'])) {
                                    echo '<img src="data:image/jpeg;base64,' . base64_encode($row['imagen']) . '" width="100">';
                                } else {
                                    echo 'Sin imagen';
                                }
                                echo "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>No se encontraron resultados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>

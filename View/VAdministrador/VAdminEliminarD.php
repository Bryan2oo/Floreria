<?php
include("../../Config/conexion.php");
include("../../Model/MAdministrador/MMenuNavAdmin2.php"); 

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conectBd, $_GET['id']);
    $sql = "SELECT * FROM productos WHERE id = '$id'";
    $resultado = mysqli_query($conectBd, $sql);
    $producto = mysqli_fetch_assoc($resultado);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Eliminar Producto</title>
    <link rel="stylesheet" href="../../Public/css/CssAdministrador/stylesNavAdmin.css" />
    <link rel="stylesheet" href="../../Public/css/stylesFondo.css" />
    <link rel="stylesheet" href="../../Public/css/CssAdministrador/stylesAdminEliminar2.css" />
</head>
<body>
    <?php if (isset($producto) && $producto !== null) { ?>
        <div class="confirmacion">
            <h2>¿Estás seguro de que quieres eliminar "<?php echo htmlspecialchars($producto['nombre']); ?>"?</h2>
            <p>Esta acción no se puede deshacer.</p>
            <div class="botones">
                <form method="POST" action="../../Controller/CAdministrador/CAdminEliminar.php" style="display: inline;">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <button type="submit" class="boton-eliminar">Sí, eliminar</button>
                </form>
                <a href="VAdminMostrarD.php" class="boton-cancelar">No, cancelar</a>
            </div>
        </div>
    <?php } else { ?>
        <div class="confirmacion">
            <h2>Error: Producto no encontrado</h2>
            <div class="botones">
                <a href="VAdminMostrarD.php" class="boton-cancelar">Volver a la lista</a>
            </div>
        </div>
    <?php } ?>
</body>
</html>
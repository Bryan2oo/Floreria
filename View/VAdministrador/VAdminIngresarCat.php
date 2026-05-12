<?php 
include ("../../Model/MAdministrador/MMenuNavAdmin2.php");
include("../../Config/conexion.php");

$mensaje_categoria = '';
$categorias = mysqli_query($conectBd, "SELECT * FROM categorias_ocasion");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_tipo']) && $_POST['form_tipo'] === 'categoria') {
    $id_categoria = intval($_POST['categoria_id']);
    $nuevo_nombre = $_POST['nuevo_nombre'];
    $nueva_descripcion = $_POST['nueva_descripcion'];

    if (isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['error'] == UPLOAD_ERR_OK) {
        $imagen_binaria = addslashes(file_get_contents($_FILES['nueva_imagen']['tmp_name']));

        $sql = "UPDATE categorias_ocasion 
                SET nombre = '$nuevo_nombre', descripcion = '$nueva_descripcion', imagen = '$imagen_binaria'
                WHERE id = $id_categoria";

        if (mysqli_query($conectBd, $sql)) {
            $mensaje_categoria = '<div class="mensaje-exito">✔ Categoría actualizada correctamente</div>';
            // Actualizar listado para reflejar cambios
            $categorias = mysqli_query($conectBd, "SELECT * FROM categorias_ocasion");
        } else {
            $mensaje_categoria = '<div class="alerta-error">Error al actualizar la categoría en la base de datos.</div>';
        }
    } else {
        $mensaje_categoria = '<div class="alerta-error">Error al subir la imagen de la categoría.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Categoría Existente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../Public/css/CssAdministrador/stylesNavAdmin.css">
    <link rel="stylesheet" href="../../Public/css/CssAdministrador/stylesAdminIngresar.css">
    <link rel="stylesheet" href="../../Public/css/stylesFondo.css">
    <style>
        .mensaje-exito {
            color: #28a745;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        .alerta-error {
            color: #dc3545;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 4px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

<main class="admin-login-container">
    <section class="login-form">
        <h1>Editar Categoría Existente</h1>
        <p>Selecciona una categoría para actualizar su información.</p>

        <?php echo $mensaje_categoria; ?>

        <form action="" method="post" enctype="multipart/form-data" novalidate>
            <input type="hidden" name="form_tipo" value="categoria">

            <div class="mb-3">
                <label for="categoria_id" class="form-label">Seleccionar categoría</label>
                <select class="form-control" name="categoria_id" id="categoria_id" required>
                    <option value="">-- Selecciona una categoría --</option>
                    <?php
                    mysqli_data_seek($categorias, 0);
                    while ($cat = mysqli_fetch_assoc($categorias)) {
                        echo "<option value='{$cat['id']}'>" . htmlspecialchars($cat['nombre']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="nuevo_nombre" class="form-label">Nuevo nombre</label>
                <input type="text" class="form-control" name="nuevo_nombre" id="nuevo_nombre" required>
            </div>

            <div class="mb-3">
                <label for="nueva_descripcion" class="form-label">Nueva descripción</label>
                <textarea class="form-control" name="nueva_descripcion" id="nueva_descripcion" required></textarea>
            </div>

            <div class="mb-3">
                <label for="nueva_imagen" class="form-label">Nueva imagen</label>
                <input type="file" class="form-control" name="nueva_imagen" id="nueva_imagen" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-warning w-100">Actualizar Categoría</button>
        </form>
    </section>
</main>

</body>
</html>

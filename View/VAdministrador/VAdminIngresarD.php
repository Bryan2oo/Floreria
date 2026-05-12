<?php 
include ("../../Model/MAdministrador/MMenuNavAdmin2.php");
include("../../Config/conexion.php");

$mostrarConfirmacion = isset($_GET['exito']) && $_GET['exito'] == 'true';
$mensaje_error = isset($_GET['error']) ? $_GET['error'] : '';
$categorias = mysqli_query($conectBd, "SELECT * FROM categorias_ocasion");
$promociones = mysqli_query($conectBd, "SELECT * FROM promociones");

// Conservar los datos del formulario si hubo un error
$datos_formulario = [
    'tipo' => isset($_GET['tipo']) ? $_GET['tipo'] : '',
    'nombre' => isset($_GET['nombre']) ? $_GET['nombre'] : '',
    'precio' => isset($_GET['precio']) ? $_GET['precio'] : '',
    'stock' => isset($_GET['stock']) ? $_GET['stock'] : '',
    'descripcion' => isset($_GET['descripcion']) ? $_GET['descripcion'] : '',
    'categorias' => isset($_GET['categorias']) ? $_GET['categorias'] : [],
    'promocion_id' => isset($_GET['promocion_id']) ? $_GET['promocion_id'] : ''
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $mostrarConfirmacion ? 'Producto Ingresado' : 'Ingresar Producto'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../Public/css/CssAdministrador/stylesNavAdmin.css">
    <link rel="stylesheet" href="../../Public/css/CssAdministrador/stylesAdminIngresar.css">
    <link rel="stylesheet" href="../../Public/css/stylesFondo.css">
    <style>
        .confirmacion-exito {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            max-width: 500px;
            margin: 50px auto;
            text-align: center;
        }
        .mensaje-exito {
            color: #28a745;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        .boton-continuar {
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px;
            font-size: 16px;
        }
        .boton-continuar:hover {
            background-color: #218838;
        }
        .boton-finalizar {
            background-color: #17a2b8;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 4px;
            margin: 5px;
            display: inline-block;
            font-size: 16px;
        }
        .boton-finalizar:hover {
            background-color: #138496;
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

<?php if ($mostrarConfirmacion): ?>
    <div class="confirmacion-exito">
        <div class="mensaje-exito">
            ✔ Producto ingresado correctamente
        </div>
        <h2>¿Deseas añadir otro producto?</h2>
        <div class="botones">
            <a href="VAdminIngresarD.php" class="boton-continuar">Sí, añadir otro</a>
            <a href="VAdminMostrarD.php" class="boton-finalizar">No, volver al listado</a>
        </div>
    </div>
<?php else: ?>
    <main class="admin-login-container">
        <section class="login-form">
            <h1>Ingresar Producto</h1>
            <p>Introduce los datos del producto para agregarlo al sistema.</p>
            
            <?php if (!empty($mensaje_error)): ?>
                <div class="alerta-error">
                    <?php echo htmlspecialchars($mensaje_error); ?>
                </div>
            <?php endif; ?>
            
            <form action="../../Controller/CAdministrador/CAdminIngresar.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de producto</label>
                    <select class="form-control" id="tipo" name="tipo" required>
                        <option value="">Selecciona un tipo</option>
                        <option value="flor" <?php echo $datos_formulario['tipo'] == 'flor' ? 'selected' : ''; ?>>Flor</option>
                        <option value="arreglo" <?php echo $datos_formulario['tipo'] == 'arreglo' ? 'selected' : ''; ?>>Arreglo floral</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($datos_formulario['nombre']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number" class="form-control" id="precio" name="precio" step="0.01" min="0.01" value="<?php echo htmlspecialchars($datos_formulario['precio']); ?>" required>
                    <small class="text-muted">El precio debe ser mayor a 0</small>
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock disponible</label>
                    <input type="number" class="form-control" id="stock" name="stock" min="1" value="<?php echo htmlspecialchars($datos_formulario['stock']); ?>" required>
                    <small class="text-muted">El stock debe ser al menos 1</small>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" required><?php echo htmlspecialchars($datos_formulario['descripcion']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen</label>
                    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                </div>
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categorías</label>
                    <select class="form-control" id="categoria" name="categorias[]" multiple required>
                        <?php 
                        mysqli_data_seek($categorias, 0); // Reiniciar el puntero del resultado
                        while ($cat = mysqli_fetch_assoc($categorias)) { 
                            $selected = in_array($cat['id'], $datos_formulario['categorias']) ? 'selected' : '';
                        ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo $selected; ?>>
                                <?php echo htmlspecialchars($cat['nombre']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="promocion" class="form-label">Promoción</label>
                    <select class="form-control" id="promocion" name="promocion_id">
                        <option value="">Sin promoción</option>
                        <?php 
                        mysqli_data_seek($promociones, 0); // Reiniciar el puntero del resultado
                        while ($promo = mysqli_fetch_assoc($promociones)) { 
                            $selected = ($datos_formulario['promocion_id'] == $promo['id']) ? 'selected' : '';
                        ?>
                            <option value="<?php echo $promo['id']; ?>" <?php echo $selected; ?>>
                                <?php echo "Descuento: " . $promo['descuento_porcentaje'] . "%"; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Ingresar Producto</button>
            </form>
        </section>
    </main>
<?php endif; ?>

</body>
</html>
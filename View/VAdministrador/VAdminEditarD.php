<?php
include("../../Config/conexion.php");
include("../../Model/MAdministrador/MMenuNavAdmin2.php"); 

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar consulta para evitar SQL Injection
    $stmt = $conectBd->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        header("Location: ../../View/VAdministrador/VAdminMostrarD.php");
        exit();
    }

    $producto = $resultado->fetch_assoc();
    $stmt->close();

    // Obtener promociones disponibles
    $promociones = mysqli_query($conectBd, "SELECT * FROM promociones");

    // Obtener categorías disponibles
    $categorias = mysqli_query($conectBd, "SELECT * FROM categorias_ocasion");

    // Obtener promoción actual del producto
    $promo_actual = mysqli_query($conectBd, "SELECT promocion_id FROM promocion_producto WHERE producto_id = $id");
    $promocionSeleccionada = mysqli_fetch_assoc($promo_actual)['promocion_id'] ?? '';

    // Obtener categorías actuales del producto
    $categorias_actuales = [];
    $resCat = mysqli_query($conectBd, "SELECT categoria_id FROM producto_categoria WHERE producto_id = $id");
    while ($cat = mysqli_fetch_assoc($resCat)) {
        $categorias_actuales[] = $cat['categoria_id'];
    }

    // Resetear punteros de resultados
    mysqli_data_seek($promociones, 0);
    mysqli_data_seek($categorias, 0);

} else {
    header("Location: ../../View/VAdministrador/VAdminMostrarD.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Producto - J & A</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Montserrat:wght@400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../../Public/css/CssAdministrador/stylesNavAdmin.css">
    <link rel="stylesheet" href="../../Public/css/CssAdministrador/stylesAdminEditar2.css">
    <link rel="stylesheet" href="../../Public/css/stylesFondo.css">
    <style>
        .img-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            display: none;
        }
        .current-image {
            max-width: 200px;
            max-height: 200px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<main class="container my-5">
    <h1 class="mb-4">Editar Producto</h1>
    <form action="../../Controller/CAdministrador/CAdminEditar.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($producto['id']); ?>">

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <input type="text" class="form-control" name="tipo" value="<?php echo htmlspecialchars($producto['tipo']); ?>" required>
                    <div class="invalid-feedback">Por favor ingrese el tipo de producto</div>
                </div>
                
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
                    <div class="invalid-feedback">Por favor ingrese el nombre del producto</div>
                </div>
                
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number" class="form-control" step="0.01" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required min="0">
                    <div class="invalid-feedback">Por favor ingrese un precio válido</div>
                </div>
                
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" class="form-control" name="stock" value="<?php echo htmlspecialchars($producto['stock']); ?>" required min="0">
                    <div class="invalid-feedback">Por favor ingrese la cantidad en stock</div>
                </div>
                
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion" rows="3" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
                    <div class="invalid-feedback">Por favor ingrese una descripción</div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Imagen actual</label><br>
                    <?php if (!empty($producto['imagen'])): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($producto['imagen']); ?>" class="current-image img-thumbnail">
                    <?php else: ?>
                        <div class="alert alert-warning">No hay imagen cargada</div>
                    <?php endif; ?>
                </div>
                
                <div class="mb-3">
                    <label for="imagen" class="form-label">Nueva Imagen (opcional)</label>
                    <input type="file" class="form-control" name="imagen" id="imagen" accept="image/jpeg, image/png, image/gif">
                    <div class="invalid-feedback">Solo se permiten imágenes JPEG, PNG o GIF</div>
                    <small class="form-text text-muted">Tamaño máximo: 2MB</small>
                    <img id="imagePreview" class="img-preview img-thumbnail">
                </div>
                
                <div class="mb-3">
                    <label for="promocion" class="form-label">Promoción</label>
                    <select name="promocion" class="form-select">
                        <option value="">Sin promoción</option>
                        <?php while ($promo = mysqli_fetch_assoc($promociones)): ?>
                            <option value="<?php echo htmlspecialchars($promo['id']); ?>" <?php echo ($promo['id'] == $promocionSeleccionada) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($promo['descuento_porcentaje']); ?>% de descuento
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="categorias" class="form-label">Categorías</label>
                    <select name="categorias[]" class="form-select" multiple size="4">
                        <?php while ($cat = mysqli_fetch_assoc($categorias)): ?>
                            <option value="<?php echo htmlspecialchars($cat['id']); ?>" <?php echo in_array($cat['id'], $categorias_actuales) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['nombre']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <small class="form-text text-muted">Mantén presionada la tecla Ctrl para seleccionar múltiples opciones</small>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-primary px-4">Actualizar Producto</button>
            <a href="../../View/VAdministrador/VAdminMostrarD.php" class="btn btn-outline-secondary px-4">Cancelar</a>
        </div>
    </form>
</main>

<script>
// Mostrar vista previa de la imagen seleccionada
document.getElementById('imagen').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});

// Validación del formulario
(function() {
    'use strict';
    
    const forms = document.querySelectorAll('.needs-validation');
    
    Array.from(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            // Validar imagen
            const imagenInput = document.getElementById('imagen');
            if (imagenInput.files.length > 0) {
                const file = imagenInput.files[0];
                const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                const maxSize = 2 * 1024 * 1024; // 2MB
                
                if (!validTypes.includes(file.type)) {
                    imagenInput.classList.add('is-invalid');
                    event.preventDefault();
                    event.stopPropagation();
                    return;
                }
                
                if (file.size > maxSize) {
                    alert('La imagen es demasiado grande. El tamaño máximo permitido es 2MB.');
                    event.preventDefault();
                    return;
                }
            }
            
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
include("../../Config/conexion.php");

// Consulta mejorada para obtener productos con sus relaciones
$sql = "SELECT 
    p.id,
    p.tipo,
    p.nombre,
    p.precio,
    p.descripcion,
    p.stock,
    p.imagen,
    pr.descuento_porcentaje AS promocion,
    GROUP_CONCAT(DISTINCT c.nombre SEPARATOR ', ') AS categorias
FROM productos p
LEFT JOIN promocion_producto pp ON p.id = pp.producto_id
LEFT JOIN promociones pr ON pr.id = pp.promocion_id
LEFT JOIN producto_categoria pc ON p.id = pc.producto_id
LEFT JOIN categorias_ocasion c ON c.id = pc.categoria_id
GROUP BY p.id";

$resultado = mysqli_query($conectBd, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conectBd));
}

$mensaje = isset($_GET['mensaje']) ? htmlspecialchars($_GET['mensaje']) : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../Public/css/CssAdministrador/stylesAdminMostrar.css">
    <link rel="stylesheet" href="../../Public/css/stylesFondo.css" />
    <style>
        .img-producto {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            border-radius: 4px;
            transition: transform 0.3s ease;
        }
        .img-producto:hover {
            transform: scale(1.5);
            z-index: 100;
            position: relative;
        }
        .sin-imagen {
            font-style: italic;
            color: #6c757d;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(220, 53, 69, 0.1);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container my-5">
        <h2 class="mb-4 text-center">Lista de Productos</h2>

        <?php if ($mensaje == "eliminado"): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                ✅ Producto eliminado correctamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($mensaje == "editado"): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                ✏️ Producto actualizado correctamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-danger text-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Descripción</th>
                        <th>Stock</th>
                        <th>Promoción</th>
                        <th>Categorías</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($fila['id']); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($fila['tipo'])); ?></td>
                        <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                        <td><?php echo number_format($fila['precio'], 2); ?></td>
                        <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($fila['stock']); ?></td>
                        <td><?php echo $fila['promocion'] ? htmlspecialchars($fila['promocion']) . '%' : '<span class="sin-imagen">Ninguna</span>'; ?></td>
                        <td><?php echo $fila['categorias'] ? htmlspecialchars($fila['categorias']) : '<span class="sin-imagen">Ninguna</span>'; ?></td>
                        <td style="width: 110px;">
                            <?php if (!empty($fila['imagen']) && substr($fila['imagen'], 0, 4) != 'R0lG'): ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($fila['imagen']); ?>" 
                                     alt="Imagen de <?php echo htmlspecialchars($fila['nombre']); ?>" 
                                     class="img-producto"
                                     title="<?php echo htmlspecialchars($fila['nombre']); ?>">
                            <?php else: ?>
                                <span class="sin-imagen">Sin imagen</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="VAdminEditarD.php?id=<?php echo $fila['id']; ?>" class="btn btn-sm btn-primary flex-grow-1">Editar</a>
                                <a href="VAdminEliminarD.php?id=<?php echo $fila['id']; ?>" class="btn btn-sm btn-danger flex-grow-1" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para confirmar eliminación
        document.querySelectorAll('.btn-danger').forEach(button => {
            button.addEventListener('click', (e) => {
                if (!confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
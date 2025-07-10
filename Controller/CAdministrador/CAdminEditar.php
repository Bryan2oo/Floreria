<?php
include("../../Config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validación y sanitización de datos
    $id = intval($_POST["id"]);
    $tipo = $conectBd->real_escape_string($_POST["tipo"]);
    $nombre = $conectBd->real_escape_string($_POST["nombre"]);
    $precio = floatval($_POST["precio"]);
    $stock = intval($_POST["stock"]);
    $descripcion = $conectBd->real_escape_string($_POST["descripcion"]);
    $promocion_id = isset($_POST["promocion"]) && $_POST["promocion"] !== "" ? intval($_POST["promocion"]) : null;
    $categorias = isset($_POST["categorias"]) ? (array)$_POST["categorias"] : [];

    // Iniciar transacción
    $conectBd->begin_transaction();

    try {
        // Procesamiento de la imagen
        if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === UPLOAD_ERR_OK) {
            // Validar tipo de imagen
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($_FILES["imagen"]["tmp_name"]);

            if (in_array($mime, $allowed_types)) {
                $imagen = file_get_contents($_FILES["imagen"]["tmp_name"]);
                $stmt = $conectBd->prepare("UPDATE productos SET tipo=?, nombre=?, precio=?, stock=?, descripcion=?, imagen=? WHERE id=?");
                $stmt->bind_param("ssdissi", $tipo, $nombre, $precio, $stock, $descripcion, $imagen, $id);
                $stmt->send_long_data(5, $imagen); // Correcto: índice 5 es la imagen
            } else {
                throw new Exception("Tipo de imagen no permitido");
            }
        } else {
            // Mantener la imagen existente si no se sube nueva
            $stmt = $conectBd->prepare("UPDATE productos SET tipo=?, nombre=?, precio=?, stock=?, descripcion=? WHERE id=?");
            $stmt->bind_param("ssdisi", $tipo, $nombre, $precio, $stock, $descripcion, $id);
        }

        // Ejecutar actualización
        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar producto: " . $stmt->error);
        }
        $stmt->close();

        // Actualizar promoción
        $conectBd->query("DELETE FROM promocion_producto WHERE producto_id = $id");
        if ($promocion_id !== null) {
            $stmt = $conectBd->prepare("INSERT INTO promocion_producto (producto_id, promocion_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $id, $promocion_id);
            if (!$stmt->execute()) {
                throw new Exception("Error al actualizar promoción: " . $stmt->error);
            }
            $stmt->close();
        }

        // Actualizar categorías
        $conectBd->query("DELETE FROM producto_categoria WHERE producto_id = $id");
        foreach ($categorias as $cat_id) {
            $cat_id = intval($cat_id);
            if ($cat_id > 0) {
                $stmt = $conectBd->prepare("INSERT INTO producto_categoria (producto_id, categoria_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $id, $cat_id);
                if (!$stmt->execute()) {
                    throw new Exception("Error al actualizar categorías: " . $stmt->error);
                }
                $stmt->close();
            }
        }

        // Confirmar transacción
        $conectBd->commit();
        header("Location: ../../View/VAdministrador/VAdminMostrarD.php?mensaje=editado");
        exit();

    } catch (Exception $e) {
        // Revertir en caso de error
        $conectBd->rollback();
        header("Location: ../../View/VAdministrador/VAdminMostrarD.php?mensaje=error_actualizacion&error=" . urlencode($e->getMessage()));
        exit();
    }
}
?>
<?php
include("../../Config/conexion.php");

// Verificar que se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Tipo = $_POST["tipo"];
    $Nombre = $_POST["nombre"];
    $Precio = $_POST["precio"];
    $Stock = $_POST["stock"];
    $Descripcion = $_POST["descripcion"];

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $Imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));

        $sql = "INSERT INTO productos (tipo, nombre, descripcion, precio, stock, imagen) 
                VALUES ('$Tipo', '$Nombre', '$Descripcion', '$Precio', '$Stock', '$Imagen')";

       if (mysqli_query($conectBd, $sql)) {
    $producto_id = mysqli_insert_id($conectBd); // 🔹 Ya tienes el ID del nuevo producto

    // 🔸 Insertar las categorías seleccionadas
    if (!empty($_POST['categorias'])) {
        foreach ($_POST['categorias'] as $categoria_id) {
            $categoria_id = intval($categoria_id);
            $sql_cat = "INSERT INTO producto_categoria (producto_id, categoria_id) 
                        VALUES ($producto_id, $categoria_id)";
            mysqli_query($conectBd, $sql_cat);
        }
    }

    // 🔹 Insertar la promoción seleccionada (AQUÍ VA)
    if (!empty($_POST['promocion_id'])) {
        $promocion_id = intval($_POST['promocion_id']);
        $sql_promo = "INSERT INTO promocion_producto (promocion_id, producto_id) 
                      VALUES ($promocion_id, $producto_id)";
        mysqli_query($conectBd, $sql_promo);
    }

    // 🔸 Redirección final
    header("Location: ../../View/VAdministrador/VAdminIngresarD.php?exito=true");
    exit();
}
 else {
            header("Location: ../../View/VAdministrador/VAdminIngresarD.php?error=db");
            exit();
        }
    } else {
        header("Location: ../../View/VAdministrador/VAdminIngresarD.php?error=imagen");
        exit();
    }
} else {
    header("Location: ../../View/VAdministrador/VAdminIngresarD.php");
    exit();
}

<?php
// View/VSesionD.php
session_start();
if (!isset($_SESSION['Correo'])) {
    header("Location: ../View/VIngresarD.php");
    exit();
}
?>
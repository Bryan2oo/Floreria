<?php
include("../../Config/conexion.php");

class ProductoModel {
    private $db;

    public function __construct() {
        global $conectBd;
        $this->db = $conectBd;
    }

    public function buscarProducto($buscar) {
        if (is_numeric($buscar)) {
            $sql = "SELECT * FROM productos WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $buscar); // i = entero
        } else {
            $sql = "SELECT * FROM productos WHERE nombre LIKE ?";
            $buscar = "%$buscar%";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("s", $buscar); // s = string
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}
?>

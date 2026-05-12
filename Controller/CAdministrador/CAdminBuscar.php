<?php
include("../../Model/MAdministrador/MBuscar.php");

class FrutaController {
    private $model;

    public function __construct() {
        $this->model = new FrutaModel();
    }

    public function buscarFruta() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['buscar'])) {
            $buscar = $_POST['buscar'];
            return $this->model->buscarFruta($buscar);
        }
        return null;
    }
}

$controller = new FrutaController();
$resultados = $controller->buscarFruta();
?>

<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Provincia.php';

class ProvinciaController extends Controller
{
    protected $modulo = 'provincias';

    public function index()
    {
        $provincias = Provincia::listar();
        list($msg, $tipo) = $this->mensajeActual();
        require __DIR__ . '/../views/provincias/index.php';
    }

    public function crear()
    {
        $this->formulario(new Provincia());
    }

    public function guardar()
    {
        $provincia = new Provincia($_POST);
        if (!$provincia->validar()) {
            $this->formulario($provincia);
            return;
        }
        $provincia->crear();
        $this->redirigir("Provincia creada correctamente");
    }

    public function editar()
    {
        $provincia = Provincia::buscarPorId($_GET['id'] ?? 0);
        if (!$provincia) {
            $this->redirigir("Provincia no encontrada", 'danger');
        }
        $this->formulario($provincia);
    }

    public function actualizar()
    {
        $provincia = new Provincia($_POST);
        if (!$provincia->validar()) {
            $this->formulario($provincia);
            return;
        }
        $provincia->actualizar();
        $this->redirigir("Provincia actualizada correctamente");
    }

    public function eliminar()
    {
        $provincia = Provincia::buscarPorId($_GET['id'] ?? 0);
        if (!$provincia) {
            $this->redirigir("Provincia no encontrada", 'danger');
        }
        try {
            $provincia->eliminar();
        } catch (PDOException $e) {
            // 23000 = tiene cantones relacionados
            if ($e->getCode() == '23000') {
                $this->redirigir("No se puede eliminar: la provincia tiene cantones registrados", 'danger');
            }
            $this->redirigir("Error en la base de datos: " . $e->getMessage(), 'danger');
        }
        $this->redirigir("Provincia eliminada correctamente");
    }

    private function formulario($provincia)
    {
        require __DIR__ . '/../views/provincias/formulario.php';
    }
}

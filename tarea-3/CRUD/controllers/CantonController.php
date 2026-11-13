<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Canton.php';
require_once __DIR__ . '/../models/Provincia.php';

class CantonController extends Controller
{
    protected $modulo = 'cantones';

    public function index()
    {
        $cantones = Canton::listar();
        list($msg, $tipo) = $this->mensajeActual();
        require __DIR__ . '/../views/cantones/index.php';
    }

    public function crear()
    {
        $this->formulario(new Canton());
    }

    public function guardar()
    {
        $canton = new Canton($_POST);
        if (!$canton->validar()) {
            $this->formulario($canton);
            return;
        }
        $canton->crear();
        $this->redirigir("Cantón creado correctamente");
    }

    public function editar()
    {
        $canton = Canton::buscarPorId($_GET['id'] ?? 0);
        if (!$canton) {
            $this->redirigir("Cantón no encontrado", 'danger');
        }
        $this->formulario($canton);
    }

    public function actualizar()
    {
        $canton = new Canton($_POST);
        if (!$canton->validar()) {
            $this->formulario($canton);
            return;
        }
        $canton->actualizar();
        $this->redirigir("Cantón actualizado correctamente");
    }

    public function eliminar()
    {
        $canton = Canton::buscarPorId($_GET['id'] ?? 0);
        if (!$canton) {
            $this->redirigir("Cantón no encontrado", 'danger');
        }
        try {
            $canton->eliminar();
        } catch (PDOException $e) {
            // 23000 = tiene clientes relacionados
            if ($e->getCode() == '23000') {
                $this->redirigir("No se puede eliminar: el cantón tiene clientes registrados", 'danger');
            }
            $this->redirigir("Error en la base de datos: " . $e->getMessage(), 'danger');
        }
        $this->redirigir("Cantón eliminado correctamente");
    }

    // Carga la lista de provincias para el select y muestra la vista
    private function formulario($canton)
    {
        $provincias = Provincia::listar();
        require __DIR__ . '/../views/cantones/formulario.php';
    }
}

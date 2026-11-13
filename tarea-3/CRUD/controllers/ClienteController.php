<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Provincia.php';
require_once __DIR__ . '/../models/Canton.php';

class ClienteController extends Controller
{
    protected $modulo = 'clientes';

    public function index()
    {
        $clientes = Cliente::listar();
        list($msg, $tipo) = $this->mensajeActual();
        require __DIR__ . '/../views/clientes/index.php';
    }

    public function crear()
    {
        $this->formulario(new Cliente());
    }

    public function guardar()
    {
        $cliente = new Cliente($_POST);
        if (!$cliente->validar()) {
            $this->formulario($cliente);     // vuelve al formulario mostrando los errores
            return;
        }
        $cliente->crear();
        $this->redirigir("Cliente creado correctamente");
    }

    public function editar()
    {
        $cliente = Cliente::buscarPorId($_GET['id'] ?? 0);
        if (!$cliente) {
            $this->redirigir("Cliente no encontrado", 'danger');
        }
        $this->formulario($cliente);
    }

    public function actualizar()
    {
        $cliente = new Cliente($_POST);
        if (!$cliente->validar()) {
            $this->formulario($cliente);
            return;
        }
        $cliente->actualizar();
        $this->redirigir("Cliente actualizado correctamente");
    }

    public function eliminar()
    {
        $cliente = Cliente::buscarPorId($_GET['id'] ?? 0);
        if (!$cliente) {
            $this->redirigir("Cliente no encontrado", 'danger');
        }
        $cliente->eliminar();
        $this->redirigir("Cliente eliminado correctamente");
    }

    // Carga las listas que necesita el formulario y muestra la vista
    private function formulario($cliente)
    {
        $provincias = Provincia::listar();
        $cantones = Canton::listar();
        require __DIR__ . '/../views/clientes/formulario.php';
    }
}

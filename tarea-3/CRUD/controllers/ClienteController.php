<?php
require_once __DIR__ . '/../models/Cliente.php';

// CONTROLADOR: recibe las peticiones, usa el modelo y elige la vista
class ClienteController
{
    public function index()
    {
        $clientes = Cliente::listar();
        $msg = $_GET['msg'] ?? '';
        $tipo = ($_GET['tipo'] ?? '') === 'danger' ? 'danger' : 'success';
        require __DIR__ . '/../views/clientes/index.php';
    }

    public function crear()
    {
        $cliente = null;
        require __DIR__ . '/../views/clientes/formulario.php';
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $cliente = new Cliente($_POST);
                $cliente->crear();
                $this->redirigir("Cliente creado correctamente");
            } catch (PDOException $e) {
                $this->redirigir($this->mensajeError($e), 'danger');
            }
        }
        $this->redirigir("Petición no válida", 'danger');
    }

    public function editar()
    {
        $cliente = Cliente::buscarPorId($_GET['id'] ?? 0);
        if (!$cliente) {
            $this->redirigir("Cliente no encontrado", 'danger');
        }
        require __DIR__ . '/../views/clientes/formulario.php';
    }

    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $cliente = new Cliente($_POST);
                $cliente->actualizar();
                $this->redirigir("Cliente actualizado correctamente");
            } catch (PDOException $e) {
                $this->redirigir($this->mensajeError($e), 'danger');
            }
        }
        $this->redirigir("Petición no válida", 'danger');
    }

    public function eliminar()
    {
        $cliente = Cliente::buscarPorId($_GET['id'] ?? 0);
        if ($cliente) {
            $cliente->eliminar();
            $this->redirigir("Cliente eliminado correctamente");
        }
        $this->redirigir("Cliente no encontrado", 'danger');
    }

    // Mensaje amigable si la cédula ya existe (error 23000 = dato duplicado)
    private function mensajeError(PDOException $e)
    {
        if ($e->getCode() == '23000') {
            return "Esa cédula ya está registrada";
        }
        return "Error en la base de datos: " . $e->getMessage();
    }

    private function redirigir($mensaje, $tipo = 'success')
    {
        header("Location: index.php?msg=" . urlencode($mensaje) . "&tipo=" . $tipo);
        exit;
    }
}

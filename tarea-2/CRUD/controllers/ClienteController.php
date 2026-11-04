<?php
require_once __DIR__ . '/../models/Cliente.php';

// CONTROLADOR: recibe las peticiones, usa el modelo y elige la vista
class ClienteController
{
    // Muestra la lista de clientes
    public function index()
    {
        $clientes = Cliente::listar();
        $msg = $_GET['msg'] ?? '';
        require __DIR__ . '/../views/clientes/index.php';
    }

    // Muestra el formulario vacío (nuevo cliente)
    public function crear()
    {
        $cliente = null;
        require __DIR__ . '/../views/clientes/formulario.php';
    }

    // Guarda un cliente nuevo
    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente = new Cliente(
                $_POST['nombre'],
                $_POST['apellido'],
                $_POST['telefono'],
                $_POST['email']
            );
            $cliente->crear();
        }
        $this->redirigir("Cliente creado");
    }

    // Muestra el formulario con los datos del cliente
    public function editar()
    {
        $cliente = Cliente::buscarPorId($_GET['id'] ?? 0);
        if (!$cliente) {
            $this->redirigir("Cliente no encontrado");
        }
        require __DIR__ . '/../views/clientes/formulario.php';
    }

    // Guarda los cambios de un cliente existente
    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente = new Cliente(
                $_POST['nombre'],
                $_POST['apellido'],
                $_POST['telefono'],
                $_POST['email'],
                $_POST['id']
            );
            $cliente->actualizar();
        }
        $this->redirigir("Cliente actualizado");
    }

    // Elimina un cliente
    public function eliminar()
    {
        $cliente = Cliente::buscarPorId($_GET['id'] ?? 0);
        if ($cliente) {
            $cliente->eliminar();
        }
        $this->redirigir("Cliente eliminado");
    }

    private function redirigir($mensaje)
    {
        header("Location: index.php?msg=" . urlencode($mensaje));
        exit;
    }
}

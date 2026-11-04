<?php
require_once __DIR__ . '/controllers/ClienteController.php';

// Acción que viene en la URL (por defecto: mostrar la lista)
$accion = $_GET['accion'] ?? 'index';

$acciones_validas = ['index', 'crear', 'guardar', 'editar', 'actualizar', 'eliminar'];
if (!in_array($accion, $acciones_validas)) {
    $accion = 'index';
}

$controlador = new ClienteController();
$controlador->$accion();

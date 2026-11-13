<?php
require_once __DIR__ . '/config/Migracion.php';
require_once __DIR__ . '/controllers/ClienteController.php';
require_once __DIR__ . '/controllers/ProvinciaController.php';
require_once __DIR__ . '/controllers/CantonController.php';

// MIGRACIÓN: crea la base de datos, las tablas y los datos de prueba si todavía no existen
Migracion::ejecutar();

// Módulo (clientes, provincias o cantones) y acción que vienen en la URL
$modulo = $_GET['modulo'] ?? 'clientes';
$accion = $_GET['accion'] ?? 'index';

$controladores = [
    'clientes'   => 'ClienteController',
    'provincias' => 'ProvinciaController',
    'cantones'   => 'CantonController',
];
if (!isset($controladores[$modulo])) {
    $modulo = 'clientes';
}

$acciones_validas = ['index', 'crear', 'guardar', 'editar', 'actualizar', 'eliminar'];
if (!in_array($accion, $acciones_validas)) {
    $accion = 'index';
}

define('MODULO', $modulo);      // lo usa el menú para marcar la pestaña activa

$clase = $controladores[$modulo];
$controlador = new $clase();
$controlador->$accion();

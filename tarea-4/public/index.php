<?php
session_start();

// Migración: crea la base de datos y las tablas si todavía no existen
require_once __DIR__ . '/../config/migracion.php';
Migracion::ejecutar();

// Entidades del sistema: url => controlador
$controladores = [
    'departamentos' => 'DepartamentoController',
    'cargos' => 'CargoController',
    'empleados' => 'EmpleadoController',
    'proyectos' => 'ProyectoController',
    'asignaciones' => 'AsignacionController',
];

// Texto del menú
const MENU = [
    'departamentos' => 'Departamentos',
    'cargos' => 'Cargos',
    'empleados' => 'Empleados',
    'proyectos' => 'Proyectos',
    'asignaciones' => 'Asignaciones',
];

// Entidad y acción que vienen en la URL
$entidad = $_GET['entidad'] ?? 'empleados';
$accion = $_GET['accion'] ?? 'index';

if (!isset($controladores[$entidad])) {
    $entidad = 'empleados';
}

$acciones_validas = ['index', 'create', 'store', 'edit', 'update', 'destroy'];
if (!in_array($accion, $acciones_validas)) {
    $accion = 'index';
}

define('ENTIDAD_ACTUAL', $entidad);     // lo usa el menú para marcar la pestaña activa

$clase = $controladores[$entidad];
require_once __DIR__ . '/../controllers/' . $clase . '.php';

$controlador = new $clase();
$controlador->$accion();

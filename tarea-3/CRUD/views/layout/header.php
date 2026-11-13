<?php require_once __DIR__ . '/helpers.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD Clientes, Provincias y Cantones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary mb-3">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="index.php">Gestión de Clientes</a>
    </div>
</nav>

<div class="container-fluid px-4">

    <!-- Menú en pestañas -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link <?= MODULO === 'clientes' ? 'active' : '' ?>" href="index.php?modulo=clientes">Clientes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= MODULO === 'provincias' ? 'active' : '' ?>" href="index.php?modulo=provincias">Provincias</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= MODULO === 'cantones' ? 'active' : '' ?>" href="index.php?modulo=cantones">Cantones</a>
        </li>
    </ul>

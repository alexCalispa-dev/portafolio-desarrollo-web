<?php require_once __DIR__ . '/helpers.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema generado con Scaffolding</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary mb-3">
    <div class="container-fluid px-4">
        <span class="navbar-brand fw-bold">Sistema generado con Scaffolding</span>
    </div>
</nav>

<div class="container-fluid px-4">

    <!-- Menú en pestañas (una por entidad) -->
    <ul class="nav nav-tabs mb-4">
        <?php foreach (MENU as $url => $texto): ?>
            <li class="nav-item">
                <a class="nav-link <?= $url === ENTIDAD_ACTUAL ? 'active' : '' ?>"
                   href="index.php?entidad=<?= $url ?>"><?= $texto ?></a>
            </li>
        <?php endforeach; ?>
    </ul>

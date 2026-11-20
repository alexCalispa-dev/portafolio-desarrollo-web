<?php

declare(strict_types=1);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?> · <?= e($appName) ?></title>
    <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>">
</head>
<body>
<header class="topbar">
    <div class="topbar-inner">
        <a class="brand" href="<?= url('/') ?>"><?= e($appName) ?></a>
        <nav class="nav">
            <a href="<?= url('/') ?>">Inicio</a>
            <a href="<?= url('/proyectos') ?>">Proyectos</a>
            <a href="<?= url('/empleados') ?>">Empleados</a>
            <a href="<?= url('/asignaciones') ?>">Asignaciones</a>
        </nav>
    </div>
</header>
<main class="container">
    <?php if (!empty($flash)): ?>
        <div class="alert <?= ($flash['type'] ?? '') === 'success' ? 'alert-success' : 'alert-error' ?>">
            <?= e($flash['message'] ?? '') ?>
        </div>
    <?php endif; ?>
    <?= $content ?>
</main>
</body>
</html>

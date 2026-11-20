<?php

declare(strict_types=1);
?>
<div class="page-head">
    <div>
        <h1>Panel general</h1>
        <p class="subtitle">Resumen del sistema de gestion de proyectos</p>
    </div>
</div>

<section class="stats">
    <div class="stat-card">
        <span class="stat-label">Proyectos</span>
        <strong class="stat-value"><?= (int) $totalProyectos ?></strong>
        <a href="<?= url('/proyectos') ?>">Ver proyectos</a>
    </div>
    <div class="stat-card">
        <span class="stat-label">Empleados</span>
        <strong class="stat-value"><?= (int) $totalEmpleados ?></strong>
        <a href="<?= url('/empleados') ?>">Ver empleados</a>
    </div>
    <div class="stat-card">
        <span class="stat-label">Asignaciones</span>
        <strong class="stat-value"><?= (int) $totalAsignaciones ?></strong>
        <a href="<?= url('/asignaciones') ?>">Ver asignaciones</a>
    </div>
</section>

<section class="panel">
    <div class="panel-head">
        <h2>Ultimas asignaciones</h2>
        <a class="btn btn-small" href="<?= url('/asignaciones/crear') ?>">Nueva asignacion</a>
    </div>
    <?php if ($ultimasAsignaciones === []): ?>
        <p class="muted">Todavia no hay asignaciones registradas.</p>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th>Proyecto</th>
                    <th>Empleado</th>
                    <th>Fecha asignacion</th>
                    <th>Registrado</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($ultimasAsignaciones as $fila): ?>
                    <tr>
                        <td><?= e($fila['proyecto_nombre']) ?></td>
                        <td><?= e($fila['empleado_nombre'] . ' ' . $fila['empleado_apellido']) ?></td>
                        <td><?= e($fila['fecha_asignacion']) ?></td>
                        <td><?= e($fila['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<?php

declare(strict_types=1);
?>
<div class="page-head">
    <div>
        <h1>Asignaciones</h1>
        <p class="subtitle">Relacion entre proyectos y empleados</p>
    </div>
    <a class="btn btn-primary" href="<?= url('/asignaciones/crear') ?>">Nueva asignacion</a>
</div>

<section class="panel">
    <?php if ($asignaciones === []): ?>
        <p class="muted">No hay asignaciones registradas.</p>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th class="col-num">Nro.</th>
                    <th>Proyecto</th>
                    <th>Empleado</th>
                    <th>Fecha asignacion</th>
                    <th>Registrado</th>
                    <th class="col-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($asignaciones as $index => $fila): ?>
                    <tr>
                        <td class="col-num"><?= $index + 1 ?></td>
                        <td><?= e($fila['proyecto_nombre']) ?></td>
                        <td><?= e($fila['empleado_nombre'] . ' ' . $fila['empleado_apellido']) ?></td>
                        <td><?= e($fila['fecha_asignacion']) ?></td>
                        <td><?= e($fila['created_at']) ?></td>
                        <td class="actions">
                            <form method="post" action="<?= url('/asignaciones/' . (int) $fila['asignacion_id'] . '/eliminar') ?>" class="inline" onsubmit="return confirm('Eliminar esta asignacion?');">
                                <?= csrf_field() ?>
                                <input type="hidden" name="redirect_to" value="<?= url('/asignaciones') ?>">
                                <button type="submit" class="btn-link danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

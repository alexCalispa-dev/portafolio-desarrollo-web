<?php

declare(strict_types=1);
?>
<div class="page-head">
    <div>
        <h1><?= e($empleado['nombre'] . ' ' . $empleado['apellido']) ?></h1>
        <p class="subtitle">Detalle del empleado</p>
    </div>
    <div class="head-actions">
        <a class="btn" href="<?= url('/empleados') ?>">Volver</a>
        <a class="btn" href="<?= url('/empleados/' . (int) $empleado['empleado_id'] . '/editar') ?>">Editar</a>
        <a class="btn btn-primary" href="<?= url('/asignaciones/crear') ?>">Asignar proyecto</a>
    </div>
</div>

<section class="panel detail-grid">
    <div>
        <span class="detail-label">Nombre</span>
        <p><?= e($empleado['nombre']) ?></p>
    </div>
    <div>
        <span class="detail-label">Apellido</span>
        <p><?= e($empleado['apellido']) ?></p>
    </div>
    <div>
        <span class="detail-label">Email</span>
        <p><?= e($empleado['email']) ?></p>
    </div>
    <div>
        <span class="detail-label">Posicion</span>
        <p><?= e($empleado['posicion']) ?></p>
    </div>
    <div>
        <span class="detail-label">Registrado</span>
        <p><?= e($empleado['created_at']) ?></p>
    </div>
    <div>
        <span class="detail-label">Ultima actualizacion</span>
        <p><?= e($empleado['updated_at']) ?></p>
    </div>
</section>

<section class="panel">
    <div class="panel-head">
        <h2>Proyectos asignados</h2>
    </div>
    <?php if ($asignaciones === []): ?>
        <p class="muted">Este empleado todavia no tiene proyectos asignados.</p>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th class="col-num">Nro.</th>
                    <th>Proyecto</th>
                    <th>Fecha asignacion</th>
                    <th class="col-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($asignaciones as $index => $fila): ?>
                    <tr>
                        <td class="col-num"><?= $index + 1 ?></td>
                        <td><a href="<?= url('/proyectos/' . (int) $fila['proyecto_id']) ?>"><?= e($fila['proyecto_nombre']) ?></a></td>
                        <td><?= e($fila['fecha_asignacion']) ?></td>
                        <td class="actions">
                            <form method="post" action="<?= url('/asignaciones/' . (int) $fila['asignacion_id'] . '/eliminar') ?>" class="inline" onsubmit="return confirm('Quitar esta asignacion?');">
                                <?= csrf_field() ?>
                                <input type="hidden" name="redirect_to" value="<?= url('/empleados/' . (int) $empleado['empleado_id']) ?>">
                                <button type="submit" class="btn-link danger">Quitar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

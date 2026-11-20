<?php

declare(strict_types=1);
?>
<div class="page-head">
    <div>
        <h1><?= e($proyecto['nombre']) ?></h1>
        <p class="subtitle">Detalle del proyecto</p>
    </div>
    <div class="head-actions">
        <a class="btn" href="<?= url('/proyectos') ?>">Volver</a>
        <a class="btn" href="<?= url('/proyectos/' . (int) $proyecto['proyecto_id'] . '/editar') ?>">Editar</a>
        <a class="btn btn-primary" href="<?= url('/asignaciones/crear') ?>?proyecto=<?= (int) $proyecto['proyecto_id'] ?>">Asignar empleado</a>
    </div>
</div>

<section class="panel detail-grid">
    <div>
        <span class="detail-label">Descripcion</span>
        <p><?= e($proyecto['descripcion'] ?? '-') ?></p>
    </div>
    <div>
        <span class="detail-label">Fecha inicio</span>
        <p><?= e($proyecto['fecha_inicio']) ?></p>
    </div>
    <div>
        <span class="detail-label">Fecha fin</span>
        <p><?= e($proyecto['fecha_fin'] ?? '-') ?></p>
    </div>
    <div>
        <span class="detail-label">Registrado</span>
        <p><?= e($proyecto['created_at']) ?></p>
    </div>
    <div>
        <span class="detail-label">Ultima actualizacion</span>
        <p><?= e($proyecto['updated_at']) ?></p>
    </div>
    <div>
        <span class="detail-label">Empleados asignados</span>
        <p><?= count($empleados) ?></p>
    </div>
</section>

<section class="panel">
    <div class="panel-head">
        <h2>Equipo asignado</h2>
    </div>
    <?php if ($asignaciones === []): ?>
        <p class="muted">Este proyecto todavia no tiene empleados asignados.</p>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th class="col-num">Nro.</th>
                    <th>Empleado</th>
                    <th>Email</th>
                    <th>Posicion</th>
                    <th>Fecha asignacion</th>
                    <th class="col-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($asignaciones as $index => $fila): ?>
                    <tr>
                        <td class="col-num"><?= $index + 1 ?></td>
                        <td><?= e($fila['nombre'] . ' ' . $fila['apellido']) ?></td>
                        <td><?= e($fila['email']) ?></td>
                        <td><?= e($fila['posicion']) ?></td>
                        <td><?= e($fila['fecha_asignacion']) ?></td>
                        <td class="actions">
                            <form method="post" action="<?= url('/asignaciones/' . (int) $fila['asignacion_id'] . '/eliminar') ?>" class="inline" onsubmit="return confirm('Quitar este empleado del proyecto?');">
                                <?= csrf_field() ?>
                                <input type="hidden" name="redirect_to" value="<?= url('/proyectos/' . (int) $proyecto['proyecto_id']) ?>">
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

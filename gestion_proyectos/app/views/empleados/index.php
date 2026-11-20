<?php

declare(strict_types=1);
?>
<div class="page-head">
    <div>
        <h1>Empleados</h1>
        <p class="subtitle">Gestion del personal y sus proyectos</p>
    </div>
    <a class="btn btn-primary" href="<?= url('/empleados/crear') ?>">Nuevo empleado</a>
</div>

<section class="panel">
    <?php if ($empleados === []): ?>
        <p class="muted">No hay empleados registrados.</p>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th class="col-num">Nro.</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Posicion</th>
                    <th>Registrado</th>
                    <th class="col-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($empleados as $index => $empleado): ?>
                    <tr>
                        <td class="col-num"><?= $index + 1 ?></td>
                        <td><a href="<?= url('/empleados/' . (int) $empleado['empleado_id']) ?>"><?= e($empleado['nombre']) ?></a></td>
                        <td><?= e($empleado['apellido']) ?></td>
                        <td><?= e($empleado['email']) ?></td>
                        <td><?= e($empleado['posicion']) ?></td>
                        <td><?= e($empleado['created_at']) ?></td>
                        <td class="actions">
                            <a href="<?= url('/empleados/' . (int) $empleado['empleado_id']) ?>">Ver</a>
                            <a href="<?= url('/empleados/' . (int) $empleado['empleado_id'] . '/editar') ?>">Editar</a>
                            <form method="post" action="<?= url('/empleados/' . (int) $empleado['empleado_id'] . '/eliminar') ?>" class="inline" onsubmit="return confirm('Eliminar este empleado?');">
                                <?= csrf_field() ?>
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

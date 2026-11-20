<?php

declare(strict_types=1);
?>
<div class="page-head">
    <div>
        <h1>Proyectos</h1>
        <p class="subtitle">Gestion de proyectos y sus asignaciones</p>
    </div>
    <a class="btn btn-primary" href="<?= url('/proyectos/crear') ?>">Nuevo proyecto</a>
</div>

<section class="panel">
    <?php if ($proyectos === []): ?>
        <p class="muted">No hay proyectos registrados.</p>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th class="col-num">Nro.</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Registrado</th>
                    <th class="col-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($proyectos as $index => $proyecto): ?>
                    <tr>
                        <td class="col-num"><?= $index + 1 ?></td>
                        <td><a href="<?= url('/proyectos/' . (int) $proyecto['proyecto_id']) ?>"><?= e($proyecto['nombre']) ?></a></td>
                        <td><?= e(truncate($proyecto['descripcion'] ?? '')) ?></td>
                        <td><?= e($proyecto['fecha_inicio']) ?></td>
                        <td><?= e($proyecto['fecha_fin'] ?? '-') ?></td>
                        <td><?= e($proyecto['created_at']) ?></td>
                        <td class="actions">
                            <a href="<?= url('/proyectos/' . (int) $proyecto['proyecto_id']) ?>">Ver</a>
                            <a href="<?= url('/proyectos/' . (int) $proyecto['proyecto_id'] . '/editar') ?>">Editar</a>
                            <form method="post" action="<?= url('/proyectos/' . (int) $proyecto['proyecto_id'] . '/eliminar') ?>" class="inline" onsubmit="return confirm('Eliminar este proyecto?');">
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

<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Asignaciones</h4>
        <a href="index.php?entidad=asignaciones&accion=create" class="btn btn-primary">+ Registrar</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Empleado</th>
                        <th>Proyecto</th>
                        <th>Fecha de asignación</th>
                        <th>Horas</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($registros)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">No hay registros.</td></tr>
                <?php endif; ?>
                <?php foreach ($registros as $r): ?>
                    <tr>
                        <td><?= $r->id_asignacion ?></td>
                        <td><?= htmlspecialchars($r->id_empleado_texto) ?></td>
                        <td><?= htmlspecialchars($r->id_proyecto_texto) ?></td>
                        <td><?= htmlspecialchars($r->fecha_asignacion) ?></td>
                        <td><?= htmlspecialchars($r->horas) ?></td>
                        <td class="text-center text-nowrap">
                            <a href="index.php?entidad=asignaciones&accion=edit&id=<?= $r->id_asignacion ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="#" class="btn btn-sm btn-danger btn-eliminar"
                               data-url="index.php?entidad=asignaciones&accion=destroy&id=<?= $r->id_asignacion ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>

<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Proyectos</h4>
        <a href="index.php?entidad=proyectos&accion=create" class="btn btn-primary">+ Registrar</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha de inicio</th>
                        <th>Presupuesto</th>
                        <th>Departamento</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($registros)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">No hay registros.</td></tr>
                <?php endif; ?>
                <?php foreach ($registros as $r): ?>
                    <tr>
                        <td><?= $r->id_proyecto ?></td>
                        <td><?= htmlspecialchars($r->nombre) ?></td>
                        <td><?= htmlspecialchars($r->fecha_inicio) ?></td>
                        <td><?= number_format((float)$r->presupuesto, 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($r->id_departamento_texto) ?></td>
                        <td class="text-center text-nowrap">
                            <a href="index.php?entidad=proyectos&accion=edit&id=<?= $r->id_proyecto ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="#" class="btn btn-sm btn-danger btn-eliminar"
                               data-url="index.php?entidad=proyectos&accion=destroy&id=<?= $r->id_proyecto ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>

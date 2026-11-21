<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Cargos</h4>
        <a href="index.php?entidad=cargos&accion=create" class="btn btn-primary">+ Registrar</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Nivel</th>
                        <th>Salario base</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($registros)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">No hay registros.</td></tr>
                <?php endif; ?>
                <?php foreach ($registros as $r): ?>
                    <tr>
                        <td><?= $r->id_cargo ?></td>
                        <td><?= htmlspecialchars($r->nombre) ?></td>
                        <td><?= htmlspecialchars($r->descripcion) ?></td>
                        <td><?= htmlspecialchars($r->nivel) ?></td>
                        <td><?= number_format((float)$r->salario_base, 2, ',', '.') ?></td>
                        <td class="text-center text-nowrap">
                            <a href="index.php?entidad=cargos&accion=edit&id=<?= $r->id_cargo ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="#" class="btn btn-sm btn-danger btn-eliminar"
                               data-url="index.php?entidad=cargos&accion=destroy&id=<?= $r->id_cargo ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>

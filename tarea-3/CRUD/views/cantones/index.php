<?php require __DIR__ . '/../layout/header.php'; ?>

<?php if ($msg): ?>
    <div class="alert alert-<?= $tipo ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($msg) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Lista de cantones</h4>
        <a href="index.php?modulo=cantones&accion=crear" class="btn btn-primary">+ Nuevo cantón</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Cantón</th>
                        <th>Provincia</th>
                        <th>Extensión (km²)</th>
                        <th>Habitantes</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($cantones)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">No hay cantones registrados.</td></tr>
                <?php endif; ?>
                <?php foreach ($cantones as $c): ?>
                    <tr>
                        <td><?= $c->id_canton ?></td>
                        <td><?= htmlspecialchars($c->nombre) ?></td>
                        <td><?= htmlspecialchars($c->provincia_nombre) ?></td>
                        <td><?= number_format((float)$c->extension, 2, ',', '.') ?></td>
                        <td><?= number_format((int)$c->numero_habitantes, 0, ',', '.') ?></td>
                        <td class="text-center text-nowrap">
                            <a href="index.php?modulo=cantones&accion=editar&id=<?= $c->id_canton ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="index.php?modulo=cantones&accion=eliminar&id=<?= $c->id_canton ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('¿Eliminar este cantón?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>

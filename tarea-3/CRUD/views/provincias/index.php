<?php require __DIR__ . '/../layout/header.php'; ?>

<?php if ($msg): ?>
    <div class="alert alert-<?= $tipo ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($msg) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Lista de provincias</h4>
        <a href="index.php?modulo=provincias&accion=crear" class="btn btn-primary">+ Nueva provincia</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Extensión (km²)</th>
                        <th>N° de cantones</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($provincias)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">No hay provincias registradas.</td></tr>
                <?php endif; ?>
                <?php foreach ($provincias as $p): ?>
                    <tr>
                        <td><?= $p->id_provincia ?></td>
                        <td><?= htmlspecialchars($p->nombre) ?></td>
                        <td><?= number_format((float)$p->extension, 2, ',', '.') ?></td>
                        <td><?= $p->numero_cantones ?></td>
                        <td class="text-center text-nowrap">
                            <a href="index.php?modulo=provincias&accion=editar&id=<?= $p->id_provincia ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="index.php?modulo=provincias&accion=eliminar&id=<?= $p->id_provincia ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('¿Eliminar esta provincia?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>

<?php require __DIR__ . '/../layout/header.php'; ?>

<?php if ($msg): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($msg) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Lista de clientes</h4>
        <a href="index.php?accion=crear" class="btn btn-primary">+ Nuevo cliente</a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($clientes)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No hay clientes registrados.</td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($clientes as $c): ?>
                    <tr>
                        <td><?= $c->getId() ?></td>
                        <td><?= htmlspecialchars($c->getNombre()) ?></td>
                        <td><?= htmlspecialchars($c->getApellido()) ?></td>
                        <td><?= htmlspecialchars($c->getTelefono()) ?></td>
                        <td><?= htmlspecialchars($c->getEmail()) ?></td>
                        <td class="text-center">
                            <a href="index.php?accion=editar&id=<?= $c->getId() ?>"
                               class="btn btn-sm btn-warning">Editar</a>
                            <a href="index.php?accion=eliminar&id=<?= $c->getId() ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('¿Eliminar este cliente?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>

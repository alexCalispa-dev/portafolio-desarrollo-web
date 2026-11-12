<?php require __DIR__ . '/../layout/header.php'; ?>

<?php if ($msg): ?>
    <div class="alert alert-<?= $tipo ?> alert-dismissible fade show" role="alert">
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
            <table class="table table-striped table-hover table-sm align-middle mb-0 small">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Cédula</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>F. Nacimiento</th>
                        <th>Género</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Ciudad</th>
                        <th>Provincia</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($clientes)): ?>
                    <tr>
                        <td colspan="13" class="text-center text-muted py-4">No hay clientes registrados.</td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($clientes as $c): ?>
                    <tr>
                        <td><?= $c->id_cliente ?></td>
                        <td><?= htmlspecialchars($c->cedula) ?></td>
                        <td><?= htmlspecialchars($c->nombres) ?></td>
                        <td><?= htmlspecialchars($c->apellidos) ?></td>
                        <td><?= htmlspecialchars($c->fecha_nacimiento) ?></td>
                        <td><?= htmlspecialchars($c->genero) ?></td>
                        <td><?= htmlspecialchars($c->telefono) ?></td>
                        <td><?= htmlspecialchars($c->email) ?></td>
                        <td><?= htmlspecialchars($c->direccion) ?></td>
                        <td><?= htmlspecialchars($c->ciudad) ?></td>
                        <td><?= htmlspecialchars($c->provincia) ?></td>
                        <td>
                            <span class="badge bg-<?= $c->estado === 'Activo' ? 'success' : 'secondary' ?>">
                                <?= htmlspecialchars($c->estado) ?>
                            </span>
                        </td>
                        <td class="text-center text-nowrap">
                            <a href="index.php?accion=editar&id=<?= $c->id_cliente ?>"
                               class="btn btn-sm btn-warning">Editar</a>
                            <a href="index.php?accion=eliminar&id=<?= $c->id_cliente ?>"
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

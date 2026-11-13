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
        <a href="index.php?modulo=clientes&accion=crear" class="btn btn-primary">+ Nuevo cliente</a>
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
                        <th>Edad</th>
                        <th>Género</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Provincia</th>
                        <th>Cantón</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($clientes)): ?>
                    <tr><td colspan="13" class="text-center text-muted py-4">No hay clientes registrados.</td></tr>
                <?php endif; ?>
                <?php foreach ($clientes as $c): ?>
                    <tr>
                        <td><?= $c->id_cliente ?></td>
                        <td><?= htmlspecialchars($c->cedula) ?></td>
                        <td><?= htmlspecialchars($c->nombres) ?></td>
                        <td><?= htmlspecialchars($c->apellidos) ?></td>
                        <td><?= htmlspecialchars($c->fecha_nacimiento) ?></td>
                        <td><?= htmlspecialchars($c->edad) ?></td>
                        <td><?= htmlspecialchars($c->genero) ?></td>
                        <td><?= htmlspecialchars($c->telefono) ?></td>
                        <td><?= htmlspecialchars($c->email) ?></td>
                        <td><?= htmlspecialchars($c->direccion) ?></td>
                        <td><?= htmlspecialchars($c->provincia_nombre) ?></td>
                        <td><?= htmlspecialchars($c->canton_nombre) ?></td>
                        <td class="text-center text-nowrap">
                            <a href="index.php?modulo=clientes&accion=editar&id=<?= $c->id_cliente ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="index.php?modulo=clientes&accion=eliminar&id=<?= $c->id_cliente ?>" class="btn btn-sm btn-danger"
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

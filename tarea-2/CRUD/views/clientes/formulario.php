<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0"><?= $cliente ? "Editar cliente" : "Nuevo cliente" ?></h4>
            </div>
            <div class="card-body">
                <form method="post" action="index.php?accion=<?= $cliente ? 'actualizar' : 'guardar' ?>">
                    <input type="hidden" name="id" value="<?= $cliente ? $cliente->getId() : '' ?>">

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required
                               value="<?= $cliente ? htmlspecialchars($cliente->getNombre()) : '' ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Apellido</label>
                        <input type="text" name="apellido" class="form-control" required
                               value="<?= $cliente ? htmlspecialchars($cliente->getApellido()) : '' ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control"
                               value="<?= $cliente ? htmlspecialchars($cliente->getTelefono()) : '' ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="<?= $cliente ? htmlspecialchars($cliente->getEmail()) : '' ?>">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success">
                            <?= $cliente ? "Actualizar" : "Guardar" ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>

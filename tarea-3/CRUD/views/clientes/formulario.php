<?php
require __DIR__ . '/../layout/header.php';

// Función pequeña para mostrar el valor actual de un campo (vacío si es nuevo)
function valor($cliente, $campo)
{
    return $cliente ? htmlspecialchars($cliente->$campo ?? '') : '';
}
?>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0"><?= $cliente ? "Editar cliente" : "Nuevo cliente" ?></h4>
            </div>
            <div class="card-body">
                <form method="post" action="index.php?accion=<?= $cliente ? 'actualizar' : 'guardar' ?>">
                    <input type="hidden" name="id_cliente" value="<?= valor($cliente, 'id_cliente') ?>">

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Cédula</label>
                            <input type="text" name="cedula" class="form-control" required
                                   pattern="[0-9]{10}" maxlength="10" title="10 dígitos"
                                   value="<?= valor($cliente, 'cedula') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nombres</label>
                            <input type="text" name="nombres" class="form-control" required
                                   value="<?= valor($cliente, 'nombres') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Apellidos</label>
                            <input type="text" name="apellidos" class="form-control" required
                                   value="<?= valor($cliente, 'apellidos') ?>">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Fecha de nacimiento</label>
                            <input type="date" name="fecha_nacimiento" class="form-control" required
                                   value="<?= valor($cliente, 'fecha_nacimiento') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Género</label>
                            <select name="genero" class="form-select" required>
                                <?php foreach (['Masculino', 'Femenino', 'Otro'] as $g): ?>
                                    <option <?= ($cliente && $cliente->genero === $g) ? 'selected' : '' ?>><?= $g ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" maxlength="15"
                                   value="<?= valor($cliente, 'telefono') ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="<?= valor($cliente, 'email') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="direccion" class="form-control"
                                   value="<?= valor($cliente, 'direccion') ?>">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Ciudad</label>
                            <input type="text" name="ciudad" class="form-control"
                                   value="<?= valor($cliente, 'ciudad') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Provincia</label>
                            <input type="text" name="provincia" class="form-control"
                                   value="<?= valor($cliente, 'provincia') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Estado</label>
                            <select name="estado" class="form-select" required>
                                <?php foreach (['Activo', 'Inactivo'] as $e): ?>
                                    <option <?= ($cliente && $cliente->estado === $e) ? 'selected' : '' ?>><?= $e ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
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

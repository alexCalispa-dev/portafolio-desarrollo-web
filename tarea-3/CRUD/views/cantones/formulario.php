<?php
require __DIR__ . '/../layout/header.php';
$errores = $canton->getErrores();
$editando = $canton->id_canton !== '';
?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0"><?= $editando ? "Editar cantón" : "Nuevo cantón" ?></h4>
            </div>
            <div class="card-body">

                <?php if ($errores): ?>
                    <div class="alert alert-danger">Revise los campos marcados en rojo.</div>
                <?php endif; ?>

                <form method="post" novalidate
                      action="index.php?modulo=cantones&accion=<?= $editando ? 'actualizar' : 'guardar' ?>">
                    <input type="hidden" name="id_canton" value="<?= valor($canton, 'id_canton') ?>">

                    <div class="mb-3">
                        <label class="form-label">Nombre del cantón *</label>
                        <input type="text" name="nombre" class="form-control<?= claseError($errores, 'nombre') ?>"
                               value="<?= valor($canton, 'nombre') ?>">
                        <?= mensajeError($errores, 'nombre') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Provincia *</label>
                        <select name="id_provincia" class="form-select<?= claseError($errores, 'id_provincia') ?>">
                            <option value="">-- Seleccione --</option>
                            <?php foreach ($provincias as $p): ?>
                                <option value="<?= $p->id_provincia ?>"
                                    <?= $canton->id_provincia == $p->id_provincia ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($p->nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= mensajeError($errores, 'id_provincia') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Extensión (km²) *</label>
                        <input type="text" name="extension" class="form-control<?= claseError($errores, 'extension') ?>"
                               value="<?= valor($canton, 'extension') ?>">
                        <?= mensajeError($errores, 'extension') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Número de habitantes *</label>
                        <input type="text" name="numero_habitantes" class="form-control<?= claseError($errores, 'numero_habitantes') ?>"
                               value="<?= valor($canton, 'numero_habitantes') ?>">
                        <?= mensajeError($errores, 'numero_habitantes') ?>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="index.php?modulo=cantones" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success"><?= $editando ? "Actualizar" : "Guardar" ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>

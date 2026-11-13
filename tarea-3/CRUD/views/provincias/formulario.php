<?php
require __DIR__ . '/../layout/header.php';
$errores = $provincia->getErrores();
$editando = $provincia->id_provincia !== '';
?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0"><?= $editando ? "Editar provincia" : "Nueva provincia" ?></h4>
            </div>
            <div class="card-body">

                <?php if ($errores): ?>
                    <div class="alert alert-danger">Revise los campos marcados en rojo.</div>
                <?php endif; ?>

                <form method="post" novalidate
                      action="index.php?modulo=provincias&accion=<?= $editando ? 'actualizar' : 'guardar' ?>">
                    <input type="hidden" name="id_provincia" value="<?= valor($provincia, 'id_provincia') ?>">

                    <div class="mb-3">
                        <label class="form-label">Nombre *</label>
                        <input type="text" name="nombre" class="form-control<?= claseError($errores, 'nombre') ?>"
                               value="<?= valor($provincia, 'nombre') ?>">
                        <?= mensajeError($errores, 'nombre') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Extensión (km²) *</label>
                        <input type="text" name="extension" class="form-control<?= claseError($errores, 'extension') ?>"
                               value="<?= valor($provincia, 'extension') ?>">
                        <?= mensajeError($errores, 'extension') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Número de cantones *</label>
                        <input type="text" name="numero_cantones" class="form-control<?= claseError($errores, 'numero_cantones') ?>"
                               value="<?= valor($provincia, 'numero_cantones') ?>">
                        <?= mensajeError($errores, 'numero_cantones') ?>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="index.php?modulo=provincias" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success"><?= $editando ? "Actualizar" : "Guardar" ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>

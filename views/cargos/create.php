<?php
require __DIR__ . '/../layout/header.php';
$errores = $registro->errores;
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0">Registrar Cargo</h4>
            </div>
            <div class="card-body">
                <!-- novalidate: las validaciones las hace el modelo (PHP) -->
                <form method="post" novalidate action="index.php?entidad=cargos&accion=store">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre *</label>
                            <input type="text" name="nombre" class="form-control<?= claseError($errores, 'nombre') ?>"
                                   value="<?= valor($registro, 'nombre') ?>">
                            <?= mensajeError($errores, 'nombre') ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Descripción *</label>
                            <input type="text" name="descripcion" class="form-control<?= claseError($errores, 'descripcion') ?>"
                                   value="<?= valor($registro, 'descripcion') ?>">
                            <?= mensajeError($errores, 'descripcion') ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nivel *</label>
                            <input type="text" name="nivel" class="form-control<?= claseError($errores, 'nivel') ?>"
                                   value="<?= valor($registro, 'nivel') ?>">
                            <?= mensajeError($errores, 'nivel') ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Salario base *</label>
                            <input type="number" step="0.01" name="salario_base" class="form-control<?= claseError($errores, 'salario_base') ?>"
                                   value="<?= valor($registro, 'salario_base') ?>">
                            <?= mensajeError($errores, 'salario_base') ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="index.php?entidad=cargos" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if ($errores): ?>
<script>
    // SweetAlert: resumen de los errores de validación
    Swal.fire({
        icon: 'error',
        title: 'Revise el formulario',
        html: <?= json_encode('<ul class="text-start mb-0"><li>' . implode('</li><li>', array_map('htmlspecialchars', $errores)) . '</li></ul>') ?>
    });
</script>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>

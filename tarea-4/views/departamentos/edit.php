<?php
require __DIR__ . '/../layout/header.php';
$errores = $registro->errores;
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0">Editar Departamento</h4>
            </div>
            <div class="card-body">
                <!-- novalidate: las validaciones las hace el modelo (PHP) -->
                <form method="post" novalidate action="index.php?entidad=departamentos&accion=update">
                    <input type="hidden" name="id_departamento" value="<?= valor($registro, 'id_departamento') ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre *</label>
                            <input type="text" name="nombre" class="form-control<?= claseError($errores, 'nombre') ?>"
                                   value="<?= valor($registro, 'nombre') ?>">
                            <?= mensajeError($errores, 'nombre') ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ubicación *</label>
                            <input type="text" name="ubicacion" class="form-control<?= claseError($errores, 'ubicacion') ?>"
                                   value="<?= valor($registro, 'ubicacion') ?>">
                            <?= mensajeError($errores, 'ubicacion') ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono *</label>
                            <input type="text" name="telefono" class="form-control<?= claseError($errores, 'telefono') ?>"
                                   value="<?= valor($registro, 'telefono') ?>">
                            <?= mensajeError($errores, 'telefono') ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Presupuesto *</label>
                            <input type="number" step="0.01" name="presupuesto" class="form-control<?= claseError($errores, 'presupuesto') ?>"
                                   value="<?= valor($registro, 'presupuesto') ?>">
                            <?= mensajeError($errores, 'presupuesto') ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="index.php?entidad=departamentos" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success">Actualizar</button>
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

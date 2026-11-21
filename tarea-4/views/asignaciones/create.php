<?php
require __DIR__ . '/../layout/header.php';
$errores = $registro->errores;
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0">Registrar Asignación</h4>
            </div>
            <div class="card-body">
                <!-- novalidate: las validaciones las hace el modelo (PHP) -->
                <form method="post" novalidate action="index.php?entidad=asignaciones&accion=store">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Empleado *</label>
                            <select name="id_empleado" class="form-select<?= claseError($errores, 'id_empleado') ?>">
                                <option value="">-- Seleccione --</option>
                                <?php foreach ($listas['id_empleado'] as $o): ?>
                                    <option value="<?= $o->id_empleado ?>" <?= $registro->id_empleado == $o->id_empleado ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($o->nombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?= mensajeError($errores, 'id_empleado') ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Proyecto *</label>
                            <select name="id_proyecto" class="form-select<?= claseError($errores, 'id_proyecto') ?>">
                                <option value="">-- Seleccione --</option>
                                <?php foreach ($listas['id_proyecto'] as $o): ?>
                                    <option value="<?= $o->id_proyecto ?>" <?= $registro->id_proyecto == $o->id_proyecto ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($o->nombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?= mensajeError($errores, 'id_proyecto') ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha de asignación *</label>
                            <input type="date" name="fecha_asignacion" class="form-control<?= claseError($errores, 'fecha_asignacion') ?>"
                                   value="<?= valor($registro, 'fecha_asignacion') ?>">
                            <?= mensajeError($errores, 'fecha_asignacion') ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Horas *</label>
                            <input type="number" name="horas" class="form-control<?= claseError($errores, 'horas') ?>"
                                   value="<?= valor($registro, 'horas') ?>">
                            <?= mensajeError($errores, 'horas') ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="index.php?entidad=asignaciones" class="btn btn-secondary">Cancelar</a>
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

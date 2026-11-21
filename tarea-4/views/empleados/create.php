<?php
require __DIR__ . '/../layout/header.php';
$errores = $registro->errores;
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0">Registrar Empleado</h4>
            </div>
            <div class="card-body">
                <!-- novalidate: las validaciones las hace el modelo (PHP) -->
                <form method="post" novalidate action="index.php?entidad=empleados&accion=store">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre completo *</label>
                            <input type="text" name="nombre" class="form-control<?= claseError($errores, 'nombre') ?>"
                                   value="<?= valor($registro, 'nombre') ?>">
                            <?= mensajeError($errores, 'nombre') ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email *</label>
                            <input type="text" name="email" class="form-control<?= claseError($errores, 'email') ?>"
                                   value="<?= valor($registro, 'email') ?>">
                            <?= mensajeError($errores, 'email') ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Departamento *</label>
                            <select name="id_departamento" class="form-select<?= claseError($errores, 'id_departamento') ?>">
                                <option value="">-- Seleccione --</option>
                                <?php foreach ($listas['id_departamento'] as $o): ?>
                                    <option value="<?= $o->id_departamento ?>" <?= $registro->id_departamento == $o->id_departamento ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($o->nombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?= mensajeError($errores, 'id_departamento') ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cargo *</label>
                            <select name="id_cargo" class="form-select<?= claseError($errores, 'id_cargo') ?>">
                                <option value="">-- Seleccione --</option>
                                <?php foreach ($listas['id_cargo'] as $o): ?>
                                    <option value="<?= $o->id_cargo ?>" <?= $registro->id_cargo == $o->id_cargo ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($o->nombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?= mensajeError($errores, 'id_cargo') ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="index.php?entidad=empleados" class="btn btn-secondary">Cancelar</a>
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

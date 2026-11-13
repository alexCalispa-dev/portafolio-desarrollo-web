<?php
require __DIR__ . '/../layout/header.php';
$errores = $cliente->getErrores();
$editando = $cliente->id_cliente !== '';
?>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0"><?= $editando ? "Editar cliente" : "Nuevo cliente" ?></h4>
            </div>
            <div class="card-body">

                <?php if ($errores): ?>
                    <div class="alert alert-danger">Revise los campos marcados en rojo.</div>
                <?php endif; ?>

                <!-- novalidate: así las validaciones las hace el modelo (PHP) y no el navegador -->
                <form method="post" novalidate
                      action="index.php?modulo=clientes&accion=<?= $editando ? 'actualizar' : 'guardar' ?>">
                    <input type="hidden" name="id_cliente" value="<?= valor($cliente, 'id_cliente') ?>">

                    <div class="row g-3">
                        <!-- 1 -->
                        <div class="col-md-4">
                            <label class="form-label">Cédula</label>
                            <input type="text" name="cedula" class="form-control" maxlength="20"
                                   value="<?= valor($cliente, 'cedula') ?>">
                        </div>
                        <!-- 2 -->
                        <div class="col-md-4">
                            <label class="form-label">Nombres *</label>
                            <input type="text" name="nombres" class="form-control<?= claseError($errores, 'nombres') ?>"
                                   value="<?= valor($cliente, 'nombres') ?>">
                            <?= mensajeError($errores, 'nombres') ?>
                        </div>
                        <!-- 3 -->
                        <div class="col-md-4">
                            <label class="form-label">Apellidos *</label>
                            <input type="text" name="apellidos" class="form-control<?= claseError($errores, 'apellidos') ?>"
                                   value="<?= valor($cliente, 'apellidos') ?>">
                            <?= mensajeError($errores, 'apellidos') ?>
                        </div>

                        <!-- 4 -->
                        <div class="col-md-4">
                            <label class="form-label">Fecha de nacimiento *</label>
                            <input type="date" name="fecha_nacimiento" class="form-control<?= claseError($errores, 'fecha_nacimiento') ?>"
                                   value="<?= valor($cliente, 'fecha_nacimiento') ?>">
                            <?= mensajeError($errores, 'fecha_nacimiento') ?>
                        </div>
                        <!-- 5 -->
                        <div class="col-md-4">
                            <label class="form-label">Edad</label>
                            <input type="text" name="edad" class="form-control<?= claseError($errores, 'edad') ?>"
                                   value="<?= valor($cliente, 'edad') ?>">
                            <?= mensajeError($errores, 'edad') ?>
                        </div>
                        <!-- 6 -->
                        <div class="col-md-4">
                            <label class="form-label">Género</label>
                            <select name="genero" class="form-select">
                                <?php foreach (['Masculino', 'Femenino', 'Otro'] as $g): ?>
                                    <option <?= $cliente->genero === $g ? 'selected' : '' ?>><?= $g ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- 7 -->
                        <div class="col-md-4">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" maxlength="20"
                                   value="<?= valor($cliente, 'telefono') ?>">
                        </div>
                        <!-- 8 -->
                        <div class="col-md-4">
                            <label class="form-label">Email *</label>
                            <input type="text" name="email" class="form-control<?= claseError($errores, 'email') ?>" maxlength="100"
                                   value="<?= valor($cliente, 'email') ?>">
                            <?= mensajeError($errores, 'email') ?>
                        </div>
                        <!-- 9 -->
                        <div class="col-md-4">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="direccion" class="form-control" maxlength="150"
                                   value="<?= valor($cliente, 'direccion') ?>">
                        </div>

                        <!-- 10 -->
                        <div class="col-md-6">
                            <label class="form-label">Provincia *</label>
                            <select name="id_provincia" id="id_provincia" class="form-select<?= claseError($errores, 'id_canton') ?>">
                                <option value="">-- Seleccione --</option>
                                <?php foreach ($provincias as $p): ?>
                                    <option value="<?= $p->id_provincia ?>"
                                        <?= $cliente->id_provincia == $p->id_provincia ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($p->nombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- 11 -->
                        <div class="col-md-6">
                            <label class="form-label">Cantón *</label>
                            <select name="id_canton" id="id_canton" class="form-select<?= claseError($errores, 'id_canton') ?>">
                                <option value="">-- Seleccione --</option>
                                <?php foreach ($cantones as $ca): ?>
                                    <option value="<?= $ca->id_canton ?>" data-provincia="<?= $ca->id_provincia ?>"
                                        <?= $cliente->id_canton == $ca->id_canton ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($ca->nombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?= mensajeError($errores, 'id_canton') ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="index.php?modulo=clientes" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success"><?= $editando ? "Actualizar" : "Guardar" ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Al elegir una provincia, el select de cantón muestra solo los cantones de esa provincia
    var selProvincia = document.getElementById('id_provincia');
    var selCanton = document.getElementById('id_canton');

    function filtrarCantones() {
        var provincia = selProvincia.value;
        for (var i = 0; i < selCanton.options.length; i++) {
            var opcion = selCanton.options[i];
            if (opcion.value === '') continue;          // la opción "-- Seleccione --"
            var coincide = (opcion.dataset.provincia === provincia);
            opcion.hidden = !coincide;
            opcion.disabled = !coincide;
        }
        // si el cantón elegido no es de esta provincia, se limpia
        if (selCanton.selectedOptions[0] && selCanton.selectedOptions[0].disabled) {
            selCanton.value = '';
        }
    }

    selProvincia.addEventListener('change', function () {
        selCanton.value = '';
        filtrarCantones();
    });
    filtrarCantones();   // al cargar la página (también sirve al editar)
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>

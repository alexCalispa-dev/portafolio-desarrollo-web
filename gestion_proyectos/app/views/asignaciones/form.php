<?php

declare(strict_types=1);
?>
<div class="page-head">
    <div>
        <h1>Nueva asignacion</h1>
        <p class="subtitle">Selecciona un proyecto y un empleado</p>
    </div>
    <a class="btn" href="<?= url('/asignaciones') ?>">Volver</a>
</div>

<section class="panel form-panel">
    <?php if (isset($errors['duplicado'])): ?>
        <p class="error block"><?= e($errors['duplicado']) ?></p>
    <?php endif; ?>
    <form method="post" action="<?= e($action) ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="redirect_to" value="<?= e($redirectTo) ?>">
        <div class="field-row">
            <div class="field">
                <label for="proyecto_id">Proyecto *</label>
                <select id="proyecto_id" name="proyecto_id" required>
                    <option value="">Seleccione un proyecto</option>
                    <?php foreach ($proyectos as $proyecto): ?>
                        <option value="<?= (int) $proyecto['proyecto_id'] ?>"<?= selected((string) ($values['proyecto_id'] ?? ''), (string) $proyecto['proyecto_id']) ?>><?= e($proyecto['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errors['proyecto_id'])): ?><p class="error"><?= e($errors['proyecto_id']) ?></p><?php endif; ?>
            </div>
            <div class="field">
                <label for="empleado_id">Empleado *</label>
                <select id="empleado_id" name="empleado_id" required>
                    <option value="">Seleccione un empleado</option>
                    <?php foreach ($empleados as $empleado): ?>
                        <option value="<?= (int) $empleado['empleado_id'] ?>"<?= selected((string) ($values['empleado_id'] ?? ''), (string) $empleado['empleado_id']) ?>><?= e($empleado['nombre'] . ' ' . $empleado['apellido']) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errors['empleado_id'])): ?><p class="error"><?= e($errors['empleado_id']) ?></p><?php endif; ?>
            </div>
        </div>
        <div class="field">
            <label for="fecha_asignacion">Fecha asignacion *</label>
            <input id="fecha_asignacion" name="fecha_asignacion" type="date" value="<?= old_value($values, 'fecha_asignacion') ?>" required>
            <?php if (isset($errors['fecha_asignacion'])): ?><p class="error"><?= e($errors['fecha_asignacion']) ?></p><?php endif; ?>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <a class="btn" href="<?= url('/asignaciones') ?>">Cancelar</a>
        </div>
    </form>
</section>

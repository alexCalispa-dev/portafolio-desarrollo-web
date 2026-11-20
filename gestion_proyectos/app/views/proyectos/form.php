<?php

declare(strict_types=1);
?>
<div class="page-head">
    <div>
        <h1><?= $proyecto === null ? 'Nuevo proyecto' : 'Editar proyecto' ?></h1>
        <p class="subtitle">Los campos marcados con * son obligatorios</p>
    </div>
    <a class="btn" href="<?= url('/proyectos') ?>">Volver</a>
</div>

<section class="panel form-panel">
    <form method="post" action="<?= e($action) ?>">
        <?= csrf_field() ?>
        <div class="field">
            <label for="nombre">Nombre *</label>
            <input id="nombre" name="nombre" type="text" maxlength="150" value="<?= old_value($values, 'nombre') ?>" required>
            <?php if (isset($errors['nombre'])): ?><p class="error"><?= e($errors['nombre']) ?></p><?php endif; ?>
        </div>
        <div class="field">
            <label for="descripcion">Descripcion</label>
            <textarea id="descripcion" name="descripcion" rows="4"><?= e((string) ($values['descripcion'] ?? '')) ?></textarea>
        </div>
        <div class="field-row">
            <div class="field">
                <label for="fecha_inicio">Fecha inicio *</label>
                <input id="fecha_inicio" name="fecha_inicio" type="date" value="<?= old_value($values, 'fecha_inicio') ?>" required>
                <?php if (isset($errors['fecha_inicio'])): ?><p class="error"><?= e($errors['fecha_inicio']) ?></p><?php endif; ?>
            </div>
            <div class="field">
                <label for="fecha_fin">Fecha fin</label>
                <input id="fecha_fin" name="fecha_fin" type="date" value="<?= old_value($values, 'fecha_fin') ?>">
                <?php if (isset($errors['fecha_fin'])): ?><p class="error"><?= e($errors['fecha_fin']) ?></p><?php endif; ?>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <a class="btn" href="<?= url('/proyectos') ?>">Cancelar</a>
        </div>
    </form>
</section>

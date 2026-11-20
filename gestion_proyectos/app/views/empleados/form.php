<?php

declare(strict_types=1);
?>
<div class="page-head">
    <div>
        <h1><?= $empleado === null ? 'Nuevo empleado' : 'Editar empleado' ?></h1>
        <p class="subtitle">Los campos marcados con * son obligatorios</p>
    </div>
    <a class="btn" href="<?= url('/empleados') ?>">Volver</a>
</div>

<section class="panel form-panel">
    <form method="post" action="<?= e($action) ?>">
        <?= csrf_field() ?>
        <div class="field-row">
            <div class="field">
                <label for="nombre">Nombre *</label>
                <input id="nombre" name="nombre" type="text" maxlength="100" value="<?= old_value($values, 'nombre') ?>" required>
                <?php if (isset($errors['nombre'])): ?><p class="error"><?= e($errors['nombre']) ?></p><?php endif; ?>
            </div>
            <div class="field">
                <label for="apellido">Apellido *</label>
                <input id="apellido" name="apellido" type="text" maxlength="100" value="<?= old_value($values, 'apellido') ?>" required>
                <?php if (isset($errors['apellido'])): ?><p class="error"><?= e($errors['apellido']) ?></p><?php endif; ?>
            </div>
        </div>
        <div class="field-row">
            <div class="field">
                <label for="email">Email *</label>
                <input id="email" name="email" type="email" maxlength="150" value="<?= old_value($values, 'email') ?>" required>
                <?php if (isset($errors['email'])): ?><p class="error"><?= e($errors['email']) ?></p><?php endif; ?>
            </div>
            <div class="field">
                <label for="posicion">Posicion *</label>
                <input id="posicion" name="posicion" type="text" maxlength="100" value="<?= old_value($values, 'posicion') ?>" required>
                <?php if (isset($errors['posicion'])): ?><p class="error"><?= e($errors['posicion']) ?></p><?php endif; ?>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <a class="btn" href="<?= url('/empleados') ?>">Cancelar</a>
        </div>
    </form>
</section>

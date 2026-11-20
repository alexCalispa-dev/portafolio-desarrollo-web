<?php

declare(strict_types=1);
?>
<div class="empty">
    <h1>No se pudo preparar la base de datos</h1>
    <p>Verifica que MySQL este iniciado en XAMPP y que los datos de <code>config/database.php</code> sean correctos.</p>
    <pre class="error-detail"><?= e($detail ?? '') ?></pre>
    <a class="btn btn-primary" href="<?= url('/') ?>">Reintentar</a>
</div>

<?php
// ===== Lógica de la calculadora (PHP) =====
$num1 = $_POST['num1'] ?? '';
$num2 = $_POST['num2'] ?? '';
$operador = $_POST['operador'] ?? '+';
$resultado = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!is_numeric($num1) || !is_numeric($num2)) {
        $error = 'Por favor ingrese dos números válidos.';
    } else {
        $a = (float) $num1;
        $b = (float) $num2;

        switch ($operador) {
            case '+':
                $resultado = $a + $b;
                break;
            case '-':
                $resultado = $a - $b;
                break;
            case '*':
                $resultado = $a * $b;
                break;
            case '/':
                if ($b == 0) {
                    $error = 'No se puede dividir para cero.';
                } else {
                    $resultado = $a / $b;
                }
                break;
            default:
                $error = 'Operador no válido.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es-EC">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi CV</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="contenedor">
        <h1 id="titulo">Alex Dario Calispa Castro</h1>
        <p><strong>Ocupación:</strong> Estudiante</p>
        <p><strong>Ubicacion:</strong> Quito, Pichincha, Ecuador</p>
        <h2>Perfil Profesional</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Hic accusantium accusamus nobis similique corrupti labore
            consequatur facere quis, minima quas. Cupiditate dolorem ratione
            placeat! Maxime vitae debitis id animi libero!</p>

        <h2>Estudios</h2>
        <ul>
            <li>Tecnólogo en Desarrollo de Software</li>
            <li>Maestría en Dirección de proyectos de TI</li>
            <li>Ingeniería en Software (en curso)</li>
        </ul>

        <h2>Experiencia Profesional</h2>
        <ul>
            <li>Especialista - Parque Nacional Mitad del Mundo</li>
            <li>Web Master - Secretaría de Educación Superior Senescyt</li>
            <li>Lider Técnico - Ministerio de Educación, Deporte y Cultura</li>
        </ul>

        <h2>Conocimientos Técnicos</h2>
        <ul>
            <li>Html, Css, Js</li>
            <li>TypeScript, Angular</li>
            <li>Mysql, MariaDB, MongoDB</li>
            <li>Scrum, Kanban</li>
        </ul>

        <h2>Contacto</h2>
        <ul>
            <li><strong>Teléfono: </strong>0998267136</li>
            <li><strong>Celular: </strong>0998267136</li>
            <li><strong>Correo: </strong>alex_1993sp@hotmail.com</li>
        </ul>
    </div>

    <div class="contenedor">
        <h2>Modificar Datos</h2>
        <input type="text" placeholder="Ingrese información...">
        <a href="">Guardar Cambios</a>
    </div>

    <!-- ===== Calculadora ===== -->
    <div class="contenedor" id="calculadora">
        <h2>Calculadora</h2>
        <form method="post" action="#calculadora" class="calc-form">
            <input type="text" name="num1" placeholder="Primer número"
                value="<?= htmlspecialchars($num1) ?>">

            <select name="operador">
                <option value="+" <?= $operador === '+' ? 'selected' : '' ?>>+ Suma</option>
                <option value="-" <?= $operador === '-' ? 'selected' : '' ?>>− Resta</option>
                <option value="*" <?= $operador === '*' ? 'selected' : '' ?>>× Multiplicación</option>
                <option value="/" <?= $operador === '/' ? 'selected' : '' ?>>÷ División</option>
            </select>

            <input type="text" name="num2" placeholder="Segundo número"
                value="<?= htmlspecialchars($num2) ?>">

            <button type="submit">Calcular</button>
        </form>

        <?php if ($error !== ''): ?>
            <p class="mensaje error"><?= htmlspecialchars($error) ?></p>
        <?php elseif ($resultado !== null): ?>
            <p class="mensaje resultado">
                <?= htmlspecialchars($num1) ?> <?= htmlspecialchars($operador) ?>
                <?= htmlspecialchars($num2) ?> = <strong><?= round($resultado, 4) ?></strong>
            </p>
        <?php endif; ?>
    </div>
</body>

</html>

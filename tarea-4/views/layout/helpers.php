<?php
// Funciones pequeñas para que las vistas queden sencillas

// Valor de un campo, listo para mostrarse dentro de un input
function valor($objeto, $campo)
{
    return htmlspecialchars($objeto->$campo);
}

// Agrega la clase roja de Bootstrap si el campo tiene error
function claseError($errores, $campo)
{
    return isset($errores[$campo]) ? ' is-invalid' : '';
}

// Muestra el texto del error debajo del campo
function mensajeError($errores, $campo)
{
    if (!isset($errores[$campo])) {
        return '';
    }
    return '<div class="invalid-feedback">' . htmlspecialchars($errores[$campo]) . '</div>';
}

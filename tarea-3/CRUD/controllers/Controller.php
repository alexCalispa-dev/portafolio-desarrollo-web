<?php
// Clase base: lo que comparten los tres controladores
class Controller
{
    protected $modulo;      // clientes, provincias o cantones

    protected function redirigir($mensaje, $tipo = 'success')
    {
        header("Location: index.php?modulo=" . $this->modulo . "&msg=" . urlencode($mensaje) . "&tipo=" . $tipo);
        exit;
    }

    // Lee el mensaje que viene en la URL (para mostrar la alerta)
    protected function mensajeActual()
    {
        $tipo = ($_GET['tipo'] ?? '') === 'danger' ? 'danger' : 'success';
        return [$_GET['msg'] ?? '', $tipo];
    }
}

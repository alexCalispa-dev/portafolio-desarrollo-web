<?php
require_once __DIR__ . '/../models/Departamento.php';

// CONTROLADOR Departamento (generado con scaffolding.php)
class DepartamentoController
{
    private $entidad = 'departamentos';

    // Lista todos los registros
    public function index()
    {
        $registros = Departamento::todos();
        require __DIR__ . '/../views/departamentos/index.php';
    }

    // Muestra el formulario vacío
    public function create()
    {
        $registro = new Departamento();
        $this->formulario($registro, 'create');
    }

    // Guarda un registro nuevo
    public function store()
    {
        $registro = new Departamento($_POST);
        if (!$registro->validar()) {
            $this->formulario($registro, 'create');   // vuelve al formulario con los errores
            return;
        }
        $registro->crear();
        $this->alerta('success', 'Registro guardado', 'El registro se creó correctamente.');
        $this->volver();
    }

    // Muestra el formulario con los datos del registro
    public function edit()
    {
        $registro = Departamento::buscar($_GET['id'] ?? 0);
        if (!$registro) {
            $this->alerta('error', 'No encontrado', 'El registro no existe.');
            $this->volver();
        }
        $this->formulario($registro, 'edit');
    }

    // Guarda los cambios de un registro
    public function update()
    {
        $registro = new Departamento($_POST);
        if (!$registro->validar()) {
            $this->formulario($registro, 'edit');
            return;
        }
        $registro->actualizar();
        $this->alerta('success', 'Registro actualizado', 'Los cambios se guardaron correctamente.');
        $this->volver();
    }

    // Elimina un registro
    public function destroy()
    {
        $registro = Departamento::buscar($_GET['id'] ?? 0);
        if (!$registro) {
            $this->alerta('error', 'No encontrado', 'El registro no existe.');
            $this->volver();
        }
        try {
            $registro->eliminar();
            $this->alerta('success', 'Registro eliminado', 'El registro se eliminó correctamente.');
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                $this->alerta('error', 'No se puede eliminar', 'Este registro está relacionado con otros registros.');
            } else {
                $this->alerta('error', 'Error', $e->getMessage());
            }
        }
        $this->volver();
    }

    // Carga las listas para los selects (llaves foráneas) y muestra la vista
    private function formulario($registro, $vista)
    {
        $listas = [];
        require __DIR__ . '/../views/departamentos/' . $vista . '.php';
    }

    // Guarda el mensaje que luego se muestra con SweetAlert
    private function alerta($icono, $titulo, $texto)
    {
        $_SESSION['alerta'] = ['icon' => $icono, 'title' => $titulo, 'text' => $texto];
    }

    private function volver()
    {
        header("Location: index.php?entidad=" . $this->entidad);
        exit;
    }
}

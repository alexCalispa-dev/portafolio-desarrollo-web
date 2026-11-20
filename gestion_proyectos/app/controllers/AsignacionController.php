<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Asignacion;
use App\Models\Empleado;
use App\Models\Proyecto;

final class AsignacionController extends Controller
{
    public function index(): void
    {
        $this->render('asignaciones/index', [
            'title' => 'Asignaciones',
            'asignaciones' => Asignacion::allWithDetails(),
        ]);
    }

    public function create(): void
    {
        $proyecto = $_GET['proyecto'] ?? null;
        $this->render('asignaciones/form', [
            'title' => 'Nueva asignacion',
            'proyectos' => Proyecto::all(),
            'empleados' => Empleado::all(),
            'values' => [
                'proyecto_id' => is_string($proyecto) && ctype_digit($proyecto) ? (int) $proyecto : 0,
                'empleado_id' => 0,
                'fecha_asignacion' => date('Y-m-d'),
            ],
            'errors' => [],
            'action' => url('/asignaciones'),
            'redirectTo' => url('/asignaciones'),
        ]);
    }

    public function store(): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        $values = [
            'proyecto_id' => $this->integerField('proyecto_id'),
            'empleado_id' => $this->integerField('empleado_id'),
            'fecha_asignacion' => trim((string) ($_POST['fecha_asignacion'] ?? '')),
            'redirect_to' => safe_path(
                is_string($_POST['redirect_to'] ?? null) ? $_POST['redirect_to'] : null,
                url('/asignaciones')
            ),
        ];

        $errors = [];
        if ($values['proyecto_id'] === 0 || Proyecto::find($values['proyecto_id']) === null) {
            $errors['proyecto_id'] = 'Selecciona un proyecto valido.';
        }
        if ($values['empleado_id'] === 0 || Empleado::find($values['empleado_id']) === null) {
            $errors['empleado_id'] = 'Selecciona un empleado valido.';
        }
        if (!valid_date($values['fecha_asignacion'])) {
            $errors['fecha_asignacion'] = 'Selecciona una fecha valida.';
        }
        if ($errors === [] && Asignacion::exists($values['proyecto_id'], $values['empleado_id'])) {
            $errors['duplicado'] = 'Ese empleado ya esta asignado al proyecto.';
        }

        if ($errors !== []) {
            $this->render('asignaciones/form', [
                'title' => 'Nueva asignacion',
                'proyectos' => Proyecto::all(),
                'empleados' => Empleado::all(),
                'values' => $values,
                'errors' => $errors,
                'action' => url('/asignaciones'),
                'redirectTo' => $values['redirect_to'],
            ]);

            return;
        }

        Asignacion::create($values['proyecto_id'], $values['empleado_id'], $values['fecha_asignacion']);
        Session::flash('success', 'Asignacion registrada correctamente.');
        $this->redirect($values['redirect_to']);
    }

    public function destroy(int $id): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        Asignacion::delete($id);
        Session::flash('success', 'Asignacion eliminada correctamente.');
        $this->redirect(safe_path(
            is_string($_POST['redirect_to'] ?? null) ? $_POST['redirect_to'] : null,
            url('/asignaciones')
        ));
    }

    private function integerField(string $key): int
    {
        $value = $_POST[$key] ?? 0;

        return is_string($value) && ctype_digit($value) ? (int) $value : 0;
    }
}

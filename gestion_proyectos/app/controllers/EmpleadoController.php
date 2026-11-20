<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Empleado;

final class EmpleadoController extends Controller
{
    public function index(): void
    {
        $this->render('empleados/index', [
            'title' => 'Empleados',
            'empleados' => Empleado::all(),
        ]);
    }

    public function create(): void
    {
        $this->render('empleados/form', [
            'title' => 'Nuevo empleado',
            'empleado' => null,
            'values' => [],
            'errors' => [],
            'action' => url('/empleados'),
        ]);
    }

    public function store(): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        $values = $this->values();
        $errors = $this->validate($values, null);
        if ($errors !== []) {
            $this->render('empleados/form', [
                'title' => 'Nuevo empleado',
                'empleado' => null,
                'values' => $values,
                'errors' => $errors,
                'action' => url('/empleados'),
            ]);

            return;
        }

        Empleado::create($values);
        Session::flash('success', 'Empleado registrado correctamente.');
        $this->redirect(url('/empleados'));
    }

    public function show(int $id): void
    {
        $empleado = Empleado::find($id);
        if ($empleado === null) {
            $this->notFound();
        }

        $this->render('empleados/show', [
            'title' => $empleado['nombre'] . ' ' . $empleado['apellido'],
            'empleado' => $empleado,
            'proyectos' => Empleado::proyectos($id),
            'asignaciones' => Empleado::asignaciones($id),
        ]);
    }

    public function edit(int $id): void
    {
        $empleado = Empleado::find($id);
        if ($empleado === null) {
            $this->notFound();
        }

        $this->render('empleados/form', [
            'title' => 'Editar empleado',
            'empleado' => $empleado,
            'values' => $empleado,
            'errors' => [],
            'action' => url('/empleados/' . $id . '/actualizar'),
        ]);
    }

    public function update(int $id): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        $empleado = Empleado::find($id);
        if ($empleado === null) {
            $this->notFound();
        }

        $values = $this->values();
        $errors = $this->validate($values, $id);
        if ($errors !== []) {
            $this->render('empleados/form', [
                'title' => 'Editar empleado',
                'empleado' => $empleado,
                'values' => $values,
                'errors' => $errors,
                'action' => url('/empleados/' . $id . '/actualizar'),
            ]);

            return;
        }

        Empleado::update($id, $values);
        Session::flash('success', 'Empleado actualizado correctamente.');
        $this->redirect(url('/empleados/' . $id));
    }

    public function destroy(int $id): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        Empleado::delete($id);
        Session::flash('success', 'Empleado eliminado correctamente.');
        $this->redirect(url('/empleados'));
    }

    private function values(): array
    {
        return [
            'nombre' => trim((string) ($_POST['nombre'] ?? '')),
            'apellido' => trim((string) ($_POST['apellido'] ?? '')),
            'email' => mb_strtolower(trim((string) ($_POST['email'] ?? ''))),
            'posicion' => trim((string) ($_POST['posicion'] ?? '')),
        ];
    }

    private function validate(array $values, ?int $id): array
    {
        $errors = [];

        foreach (['nombre', 'apellido', 'email', 'posicion'] as $field) {
            if ($values[$field] === '') {
                $labels = [
                    'nombre' => 'El nombre',
                    'apellido' => 'El apellido',
                    'email' => 'El email',
                    'posicion' => 'La posicion',
                ];
                $errors[$field] = $labels[$field] . ' es obligatorio.';
            }
        }

        if ($values['nombre'] !== '' && mb_strlen($values['nombre']) > 100) {
            $errors['nombre'] = 'El nombre no puede superar los 100 caracteres.';
        }
        if ($values['apellido'] !== '' && mb_strlen($values['apellido']) > 100) {
            $errors['apellido'] = 'El apellido no puede superar los 100 caracteres.';
        }
        if ($values['posicion'] !== '' && mb_strlen($values['posicion']) > 100) {
            $errors['posicion'] = 'La posicion no puede superar los 100 caracteres.';
        }
        if ($values['email'] !== '') {
            if (mb_strlen($values['email']) > 150) {
                $errors['email'] = 'El email no puede superar los 150 caracteres.';
            } elseif (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'El email no es valido.';
            } elseif (Empleado::emailExists($values['email'], $id)) {
                $errors['email'] = 'Ya existe un empleado con ese email.';
            }
        }

        return $errors;
    }
}

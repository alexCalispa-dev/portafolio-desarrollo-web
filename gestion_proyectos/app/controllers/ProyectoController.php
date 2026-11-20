<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Proyecto;

final class ProyectoController extends Controller
{
    public function index(): void
    {
        $this->render('proyectos/index', [
            'title' => 'Proyectos',
            'proyectos' => Proyecto::all(),
        ]);
    }

    public function create(): void
    {
        $this->render('proyectos/form', [
            'title' => 'Nuevo proyecto',
            'proyecto' => null,
            'values' => ['fecha_inicio' => date('Y-m-d')],
            'errors' => [],
            'action' => url('/proyectos'),
        ]);
    }

    public function store(): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        $values = $this->values();
        $errors = $this->validate($values);
        if ($errors !== []) {
            $this->render('proyectos/form', [
                'title' => 'Nuevo proyecto',
                'proyecto' => null,
                'values' => $values,
                'errors' => $errors,
                'action' => url('/proyectos'),
            ]);

            return;
        }

        Proyecto::create($values);
        \App\Core\Session::flash('success', 'Proyecto registrado correctamente.');
        $this->redirect(url('/proyectos'));
    }

    public function show(int $id): void
    {
        $proyecto = Proyecto::find($id);
        if ($proyecto === null) {
            $this->notFound();
        }

        $this->render('proyectos/show', [
            'title' => $proyecto['nombre'],
            'proyecto' => $proyecto,
            'empleados' => Proyecto::empleados($id),
            'asignaciones' => Proyecto::asignaciones($id),
        ]);
    }

    public function edit(int $id): void
    {
        $proyecto = Proyecto::find($id);
        if ($proyecto === null) {
            $this->notFound();
        }

        $this->render('proyectos/form', [
            'title' => 'Editar proyecto',
            'proyecto' => $proyecto,
            'values' => $proyecto,
            'errors' => [],
            'action' => url('/proyectos/' . $id . '/actualizar'),
        ]);
    }

    public function update(int $id): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        if (Proyecto::find($id) === null) {
            $this->notFound();
        }

        $values = $this->values();
        $errors = $this->validate($values);
        if ($errors !== []) {
            $this->render('proyectos/form', [
                'title' => 'Editar proyecto',
                'proyecto' => Proyecto::find($id),
                'values' => $values,
                'errors' => $errors,
                'action' => url('/proyectos/' . $id . '/actualizar'),
            ]);

            return;
        }

        Proyecto::update($id, $values);
        \App\Core\Session::flash('success', 'Proyecto actualizado correctamente.');
        $this->redirect(url('/proyectos/' . $id));
    }

    public function destroy(int $id): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        Proyecto::delete($id);
        \App\Core\Session::flash('success', 'Proyecto eliminado correctamente.');
        $this->redirect(url('/proyectos'));
    }

    private function values(): array
    {
        return [
            'nombre' => trim((string) ($_POST['nombre'] ?? '')),
            'descripcion' => trim((string) ($_POST['descripcion'] ?? '')),
            'fecha_inicio' => trim((string) ($_POST['fecha_inicio'] ?? '')),
            'fecha_fin' => trim((string) ($_POST['fecha_fin'] ?? '')),
        ];
    }

    private function validate(array $values): array
    {
        $errors = [];

        if ($values['nombre'] === '') {
            $errors['nombre'] = 'El nombre es obligatorio.';
        } elseif (mb_strlen($values['nombre']) > 150) {
            $errors['nombre'] = 'El nombre no puede superar los 150 caracteres.';
        }

        if (!valid_date($values['fecha_inicio'])) {
            $errors['fecha_inicio'] = 'Selecciona una fecha de inicio valida.';
        }

        if ($values['fecha_fin'] !== '') {
            if (!valid_date($values['fecha_fin'])) {
                $errors['fecha_fin'] = 'Selecciona una fecha de fin valida.';
            } elseif (valid_date($values['fecha_inicio']) && $values['fecha_fin'] < $values['fecha_inicio']) {
                $errors['fecha_fin'] = 'La fecha de fin no puede ser anterior al inicio.';
            }
        }

        return $errors;
    }
}

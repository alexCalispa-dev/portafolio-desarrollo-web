<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Asignacion;
use App\Models\Empleado;
use App\Models\Proyecto;

final class HomeController extends Controller
{
    public function index(): void
    {
        $this->render('home/index', [
            'title' => 'Inicio',
            'totalProyectos' => Proyecto::count(),
            'totalEmpleados' => Empleado::count(),
            'totalAsignaciones' => Asignacion::count(),
            'ultimasAsignaciones' => array_slice(Asignacion::allWithDetails(), 0, 5),
        ]);
    }
}

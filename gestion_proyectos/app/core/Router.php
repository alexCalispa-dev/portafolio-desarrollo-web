<?php

declare(strict_types=1);

namespace App\Core;

use App\Controllers\AsignacionController;
use App\Controllers\EmpleadoController;
use App\Controllers\HomeController;
use App\Controllers\ProyectoController;

final class Router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = [
            ['GET', '#^/$#', [HomeController::class, 'index']],

            ['GET', '#^/proyectos$#', [ProyectoController::class, 'index']],
            ['GET', '#^/proyectos/crear$#', [ProyectoController::class, 'create']],
            ['POST', '#^/proyectos$#', [ProyectoController::class, 'store']],
            ['GET', '#^/proyectos/(\d+)$#', [ProyectoController::class, 'show']],
            ['GET', '#^/proyectos/(\d+)/editar$#', [ProyectoController::class, 'edit']],
            ['POST', '#^/proyectos/(\d+)/actualizar$#', [ProyectoController::class, 'update']],
            ['POST', '#^/proyectos/(\d+)/eliminar$#', [ProyectoController::class, 'destroy']],

            ['GET', '#^/empleados$#', [EmpleadoController::class, 'index']],
            ['GET', '#^/empleados/crear$#', [EmpleadoController::class, 'create']],
            ['POST', '#^/empleados$#', [EmpleadoController::class, 'store']],
            ['GET', '#^/empleados/(\d+)$#', [EmpleadoController::class, 'show']],
            ['GET', '#^/empleados/(\d+)/editar$#', [EmpleadoController::class, 'edit']],
            ['POST', '#^/empleados/(\d+)/actualizar$#', [EmpleadoController::class, 'update']],
            ['POST', '#^/empleados/(\d+)/eliminar$#', [EmpleadoController::class, 'destroy']],

            ['GET', '#^/asignaciones$#', [AsignacionController::class, 'index']],
            ['GET', '#^/asignaciones/crear$#', [AsignacionController::class, 'create']],
            ['POST', '#^/asignaciones$#', [AsignacionController::class, 'store']],
            ['POST', '#^/asignaciones/(\d+)/eliminar$#', [AsignacionController::class, 'destroy']],
        ];
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $path = (string) ($_SERVER['PATH_INFO'] ?? '/');
        if ($path === '') {
            $path = '/';
        }
        $path = rawurldecode($path);
        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        foreach ($this->routes as [$routeMethod, $pattern, $handler]) {
            if ($method !== $routeMethod || !preg_match($pattern, $path, $matches)) {
                continue;
            }

            array_shift($matches);
            [$class, $action] = $handler;
            $controller = new $class();
            $controller->$action(...array_map('intval', $matches));

            return;
        }

        http_response_code(404);
        View::render('errors/404', ['title' => 'No encontrado']);
    }
}

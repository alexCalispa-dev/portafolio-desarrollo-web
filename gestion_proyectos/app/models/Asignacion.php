<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class Asignacion
{
    public static function count(): int
    {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM asignaciones')->fetchColumn();
    }

    public static function allWithDetails(): array
    {
        return Database::connection()->query(
            'SELECT a.asignacion_id, a.fecha_asignacion, a.created_at,
                    p.nombre AS proyecto_nombre,
                    e.nombre AS empleado_nombre, e.apellido AS empleado_apellido
             FROM asignaciones a
             INNER JOIN proyectos p ON p.proyecto_id = a.proyecto_id
             INNER JOIN empleados e ON e.empleado_id = a.empleado_id
             ORDER BY a.created_at DESC, a.asignacion_id DESC'
        )->fetchAll();
    }

    public static function exists(int $proyectoId, int $empleadoId): bool
    {
        $statement = Database::connection()->prepare(
            'SELECT 1 FROM asignaciones WHERE proyecto_id = ? AND empleado_id = ? LIMIT 1'
        );
        $statement->execute([$proyectoId, $empleadoId]);

        return $statement->fetchColumn() !== false;
    }

    public static function create(int $proyectoId, int $empleadoId, string $fechaAsignacion): void
    {
        $statement = Database::connection()->prepare(
            'INSERT INTO asignaciones (proyecto_id, empleado_id, fecha_asignacion) VALUES (?, ?, ?)'
        );
        $statement->execute([$proyectoId, $empleadoId, $fechaAsignacion]);
    }

    public static function delete(int $id): void
    {
        $statement = Database::connection()->prepare('DELETE FROM asignaciones WHERE asignacion_id = ?');
        $statement->execute([$id]);
    }
}

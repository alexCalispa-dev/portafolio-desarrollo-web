<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class Proyecto
{
    public static function all(): array
    {
        return Database::connection()
            ->query('SELECT * FROM proyectos ORDER BY created_at DESC, proyecto_id DESC')
            ->fetchAll();
    }

    public static function count(): int
    {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM proyectos')->fetchColumn();
    }

    public static function find(int $id): ?array
    {
        $statement = Database::connection()->prepare('SELECT * FROM proyectos WHERE proyecto_id = ?');
        $statement->execute([$id]);
        $row = $statement->fetch();

        return $row !== false ? $row : null;
    }

    public static function create(array $data): void
    {
        $statement = Database::connection()->prepare(
            'INSERT INTO proyectos (nombre, descripcion, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?)'
        );
        $statement->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['fecha_inicio'],
            $data['fecha_fin'] !== '' ? $data['fecha_fin'] : null,
        ]);
    }

    public static function update(int $id, array $data): void
    {
        $statement = Database::connection()->prepare(
            'UPDATE proyectos SET nombre = ?, descripcion = ?, fecha_inicio = ?, fecha_fin = ? WHERE proyecto_id = ?'
        );
        $statement->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['fecha_inicio'],
            $data['fecha_fin'] !== '' ? $data['fecha_fin'] : null,
            $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $statement = Database::connection()->prepare('DELETE FROM proyectos WHERE proyecto_id = ?');
        $statement->execute([$id]);
    }

    public static function empleados(int $id): array
    {
        $statement = Database::connection()->prepare(
            'SELECT e.empleado_id, e.nombre, e.apellido, e.email, e.posicion
             FROM empleados e
             INNER JOIN asignaciones a ON a.empleado_id = e.empleado_id
             WHERE a.proyecto_id = ?
             ORDER BY e.apellido, e.nombre'
        );
        $statement->execute([$id]);

        return $statement->fetchAll();
    }

    public static function asignaciones(int $id): array
    {
        $statement = Database::connection()->prepare(
            'SELECT a.asignacion_id, a.fecha_asignacion, e.nombre, e.apellido, e.email, e.posicion
             FROM asignaciones a
             INNER JOIN empleados e ON e.empleado_id = a.empleado_id
             WHERE a.proyecto_id = ?
             ORDER BY a.fecha_asignacion DESC, a.created_at DESC'
        );
        $statement->execute([$id]);

        return $statement->fetchAll();
    }
}

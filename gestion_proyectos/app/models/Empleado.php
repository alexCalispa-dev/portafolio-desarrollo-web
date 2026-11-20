<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class Empleado
{
    public static function all(): array
    {
        return Database::connection()
            ->query('SELECT * FROM empleados ORDER BY apellido, nombre')
            ->fetchAll();
    }

    public static function count(): int
    {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM empleados')->fetchColumn();
    }

    public static function find(int $id): ?array
    {
        $statement = Database::connection()->prepare('SELECT * FROM empleados WHERE empleado_id = ?');
        $statement->execute([$id]);
        $row = $statement->fetch();

        return $row !== false ? $row : null;
    }

    public static function emailExists(string $email, ?int $excludeId = null): bool
    {
        if ($excludeId === null) {
            $statement = Database::connection()->prepare('SELECT 1 FROM empleados WHERE email = ? LIMIT 1');
            $statement->execute([$email]);
        } else {
            $statement = Database::connection()->prepare(
                'SELECT 1 FROM empleados WHERE email = ? AND empleado_id <> ? LIMIT 1'
            );
            $statement->execute([$email, $excludeId]);
        }

        return $statement->fetchColumn() !== false;
    }

    public static function create(array $data): void
    {
        $statement = Database::connection()->prepare(
            'INSERT INTO empleados (nombre, apellido, email, posicion) VALUES (?, ?, ?, ?)'
        );
        $statement->execute([
            $data['nombre'],
            $data['apellido'],
            $data['email'],
            $data['posicion'],
        ]);
    }

    public static function update(int $id, array $data): void
    {
        $statement = Database::connection()->prepare(
            'UPDATE empleados SET nombre = ?, apellido = ?, email = ?, posicion = ? WHERE empleado_id = ?'
        );
        $statement->execute([
            $data['nombre'],
            $data['apellido'],
            $data['email'],
            $data['posicion'],
            $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $statement = Database::connection()->prepare('DELETE FROM empleados WHERE empleado_id = ?');
        $statement->execute([$id]);
    }

    public static function proyectos(int $id): array
    {
        $statement = Database::connection()->prepare(
            'SELECT p.proyecto_id, p.nombre, p.fecha_inicio, p.fecha_fin
             FROM proyectos p
             INNER JOIN asignaciones a ON a.proyecto_id = p.proyecto_id
             WHERE a.empleado_id = ?
             ORDER BY p.fecha_inicio DESC, p.nombre'
        );
        $statement->execute([$id]);

        return $statement->fetchAll();
    }

    public static function asignaciones(int $id): array
    {
        $statement = Database::connection()->prepare(
            'SELECT a.asignacion_id, a.fecha_asignacion, p.proyecto_id, p.nombre AS proyecto_nombre
             FROM asignaciones a
             INNER JOIN proyectos p ON p.proyecto_id = a.proyecto_id
             WHERE a.empleado_id = ?
             ORDER BY a.fecha_asignacion DESC, a.created_at DESC'
        );
        $statement->execute([$id]);

        return $statement->fetchAll();
    }
}

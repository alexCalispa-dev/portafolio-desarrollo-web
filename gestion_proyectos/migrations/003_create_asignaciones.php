<?php

declare(strict_types=1);

final class Migration003CreateAsignaciones
{
    public function up(PDO $pdo): void
    {
        $pdo->exec("CREATE TABLE IF NOT EXISTS asignaciones (
            asignacion_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            proyecto_id INT UNSIGNED NOT NULL,
            empleado_id INT UNSIGNED NOT NULL,
            fecha_asignacion DATE NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            CONSTRAINT fk_asignaciones_proyecto FOREIGN KEY (proyecto_id)
                REFERENCES proyectos (proyecto_id) ON DELETE CASCADE ON UPDATE CASCADE,
            CONSTRAINT fk_asignaciones_empleado FOREIGN KEY (empleado_id)
                REFERENCES empleados (empleado_id) ON DELETE CASCADE ON UPDATE CASCADE,
            CONSTRAINT uq_asignaciones_proyecto_empleado UNIQUE (proyecto_id, empleado_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    public function down(PDO $pdo): void
    {
        $pdo->exec('DROP TABLE IF EXISTS asignaciones');
    }
}

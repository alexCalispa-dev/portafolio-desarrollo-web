<?php
require_once __DIR__ . '/database.php';

// MIGRACIÓN: crea la base de datos, las tablas y los datos de prueba si no existen.
// Se ejecuta sola al abrir el sistema (no borra ni duplica nada).
class Migracion
{
    public static function ejecutar()
    {
        // 1) Crear la base de datos
        $servidor = Database::conectar(false);
        $servidor->exec("CREATE DATABASE IF NOT EXISTS " . Database::BD . " CHARACTER SET utf8mb4");

        // 2) Crear las tablas (primero las que no dependen de otras)
        $pdo = Database::conectar();

        $pdo->exec("CREATE TABLE IF NOT EXISTS departamentos (
            id_departamento INT AUTO_INCREMENT PRIMARY KEY,
            nombre          VARCHAR(50)   NOT NULL,
            ubicacion       VARCHAR(50)   NOT NULL,
            telefono        VARCHAR(15)   NOT NULL,
            presupuesto     DECIMAL(10,2) NOT NULL
        ) ENGINE=InnoDB");

        $pdo->exec("CREATE TABLE IF NOT EXISTS cargos (
            id_cargo     INT AUTO_INCREMENT PRIMARY KEY,
            nombre       VARCHAR(50)   NOT NULL,
            descripcion  VARCHAR(100)  NOT NULL,
            nivel        VARCHAR(20)   NOT NULL,
            salario_base DECIMAL(10,2) NOT NULL
        ) ENGINE=InnoDB");

        $pdo->exec("CREATE TABLE IF NOT EXISTS empleados (
            id_empleado     INT AUTO_INCREMENT PRIMARY KEY,
            nombre          VARCHAR(50)  NOT NULL,
            email           VARCHAR(100) NOT NULL,
            id_departamento INT          NOT NULL,
            id_cargo        INT          NOT NULL,
            FOREIGN KEY (id_departamento) REFERENCES departamentos(id_departamento),
            FOREIGN KEY (id_cargo) REFERENCES cargos(id_cargo)
        ) ENGINE=InnoDB");

        $pdo->exec("CREATE TABLE IF NOT EXISTS proyectos (
            id_proyecto     INT AUTO_INCREMENT PRIMARY KEY,
            nombre          VARCHAR(50)   NOT NULL,
            fecha_inicio    DATE          NOT NULL,
            presupuesto     DECIMAL(10,2) NOT NULL,
            id_departamento INT           NOT NULL,
            FOREIGN KEY (id_departamento) REFERENCES departamentos(id_departamento)
        ) ENGINE=InnoDB");

        $pdo->exec("CREATE TABLE IF NOT EXISTS asignaciones (
            id_asignacion    INT AUTO_INCREMENT PRIMARY KEY,
            id_empleado      INT  NOT NULL,
            id_proyecto      INT  NOT NULL,
            fecha_asignacion DATE NOT NULL,
            horas            INT  NOT NULL,
            FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado),
            FOREIGN KEY (id_proyecto) REFERENCES proyectos(id_proyecto)
        ) ENGINE=InnoDB");

        // 3) Datos de prueba (solo si la base está vacía)
        if ($pdo->query("SELECT COUNT(*) FROM departamentos")->fetchColumn() > 0) {
            return;
        }

        $stmt = $pdo->prepare("INSERT INTO departamentos (nombre, ubicacion, telefono, presupuesto) VALUES (?, ?, ?, ?)");
        $stmt->execute(['Tecnología', 'Edificio A', '022345678', 50000]);
        $stmt->execute(['Recursos Humanos', 'Edificio B', '022345679', 30000]);

        $stmt = $pdo->prepare("INSERT INTO cargos (nombre, descripcion, nivel, salario_base) VALUES (?, ?, ?, ?)");
        $stmt->execute(['Desarrollador', 'Programa y mantiene los sistemas', 'Senior', 1800]);
        $stmt->execute(['Analista de RRHH', 'Gestiona al personal', 'Junior', 1200]);

        $stmt = $pdo->prepare("INSERT INTO empleados (nombre, email, id_departamento, id_cargo) VALUES (?, ?, ?, ?)");
        $stmt->execute(['Carlos Mendoza', 'carlos@empresa.com', 1, 1]);
        $stmt->execute(['Ana Torres', 'ana@empresa.com', 2, 2]);

        $stmt = $pdo->prepare("INSERT INTO proyectos (nombre, fecha_inicio, presupuesto, id_departamento) VALUES (?, ?, ?, ?)");
        $stmt->execute(['Sistema de Inventario', '2026-03-01', 15000, 1]);
        $stmt->execute(['Portal de Empleados', '2026-05-15', 8000, 2]);

        $stmt = $pdo->prepare("INSERT INTO asignaciones (id_empleado, id_proyecto, fecha_asignacion, horas) VALUES (?, ?, ?, ?)");
        $stmt->execute([1, 1, '2026-03-05', 40]);
        $stmt->execute([2, 2, '2026-05-20', 20]);
    }
}

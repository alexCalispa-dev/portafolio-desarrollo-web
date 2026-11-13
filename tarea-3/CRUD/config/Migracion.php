<?php
require_once __DIR__ . '/Conexion.php';

// MIGRACIÓN: crea la base de datos, las tablas y los datos de prueba desde el código.
// Si ya existen, no hace nada (por eso se puede ejecutar siempre).
class Migracion
{
    public static function ejecutar()
    {
        // 1) Crear la base de datos
        $servidor = Conexion::conectar(false);
        $servidor->exec("CREATE DATABASE IF NOT EXISTS " . Conexion::BD . " CHARACTER SET utf8mb4");

        // 2) Crear las tablas (primero provincias, luego cantones, al final clientes)
        $pdo = Conexion::conectar();

        $pdo->exec("CREATE TABLE IF NOT EXISTS provincias (
            id_provincia    INT AUTO_INCREMENT PRIMARY KEY,
            nombre          VARCHAR(50)   NOT NULL,
            extension       DECIMAL(10,2) NOT NULL,
            numero_cantones INT           NOT NULL
        ) ENGINE=InnoDB");

        $pdo->exec("CREATE TABLE IF NOT EXISTS cantones (
            id_canton         INT AUTO_INCREMENT PRIMARY KEY,
            nombre            VARCHAR(50)   NOT NULL,
            id_provincia      INT           NOT NULL,
            extension         DECIMAL(10,2) NOT NULL,
            numero_habitantes INT           NOT NULL,
            FOREIGN KEY (id_provincia) REFERENCES provincias(id_provincia)
        ) ENGINE=InnoDB");

        $pdo->exec("CREATE TABLE IF NOT EXISTS clientes (
            id_cliente       INT AUTO_INCREMENT PRIMARY KEY,
            cedula           VARCHAR(20),
            nombres          VARCHAR(50)  NOT NULL,
            apellidos        VARCHAR(50)  NOT NULL,
            fecha_nacimiento DATE         NOT NULL,
            edad             VARCHAR(3),
            genero           VARCHAR(10),
            telefono         VARCHAR(20),
            email            VARCHAR(100) NOT NULL,
            direccion        VARCHAR(150),
            id_canton        INT          NOT NULL,
            fecha_registro   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (id_canton) REFERENCES cantones(id_canton)
        ) ENGINE=InnoDB");

        // 3) Datos de prueba (solo si la tabla provincias está vacía)
        if ($pdo->query("SELECT COUNT(*) FROM provincias")->fetchColumn() == 0) {
            // [provincia, extensión km², nº cantones, [[cantón, extensión km², habitantes], ...]]
            $datos = [
                ['Pichincha', 9494, 8,  [['Quito', 4204, 2700000], ['Cayambe', 1350, 86000]]],
                ['Guayas',    15430, 25, [['Guayaquil', 3118, 2700000], ['Daule', 475, 130000]]],
                ['Azuay',     8125, 15, [['Cuenca', 3086, 636000], ['Gualaceo', 346, 46000]]],
            ];

            foreach ($datos as $p) {
                $stmt = $pdo->prepare("INSERT INTO provincias (nombre, extension, numero_cantones) VALUES (?, ?, ?)");
                $stmt->execute([$p[0], $p[1], $p[2]]);
                $idProvincia = $pdo->lastInsertId();

                foreach ($p[3] as $c) {
                    $stmt = $pdo->prepare(
                        "INSERT INTO cantones (nombre, id_provincia, extension, numero_habitantes) VALUES (?, ?, ?, ?)"
                    );
                    $stmt->execute([$c[0], $idProvincia, $c[1], $c[2]]);
                }
            }

            // Dos clientes de ejemplo
            $sql = "INSERT INTO clientes (cedula, nombres, apellidos, fecha_nacimiento, edad, genero, telefono, email, direccion, id_canton)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, (SELECT id_canton FROM cantones WHERE nombre = ?))";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['1712345678', 'Juan Carlos', 'Pérez Loor', '1990-05-14', '36', 'Masculino', '022345678', 'juan.perez@mail.com', 'Av. Amazonas N24-15', 'Quito']);
            $stmt->execute(['0923456789', 'María Fernanda', 'Gómez Salas', '1995-11-02', '31', 'Femenino', '042987654', 'maria.gomez@mail.com', 'Calle 10 de Agosto 123', 'Guayaquil']);
        }
    }
}

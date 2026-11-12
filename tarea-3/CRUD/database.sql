CREATE DATABASE IF NOT EXISTS tienda_semana3 CHARACTER SET utf8mb4;
USE tienda_semana3;

-- Tabla clientes (13 campos)
CREATE TABLE IF NOT EXISTS clientes (
    id_cliente       INT AUTO_INCREMENT PRIMARY KEY,
    cedula           VARCHAR(10)  NOT NULL UNIQUE,
    nombres          VARCHAR(100) NOT NULL,
    apellidos        VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE         NOT NULL,
    genero           VARCHAR(10)  NOT NULL,
    telefono         VARCHAR(15),
    email            VARCHAR(100),
    direccion        VARCHAR(150),
    ciudad           VARCHAR(60),
    provincia        VARCHAR(60),
    estado           VARCHAR(10)  NOT NULL DEFAULT 'Activo',
    fecha_registro   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);

-- Datos de prueba (opcional)
INSERT INTO clientes (cedula, nombres, apellidos, fecha_nacimiento, genero, telefono, email, direccion, ciudad, provincia, estado) VALUES
('1712345678','Juan Carlos','Pérez Loor','1990-05-14','Masculino','022345678','juan.perez@mail.com','Av. Amazonas N24-15','Quito','Pichincha','Activo'),
('0923456789','María Fernanda','Gómez Salas','1995-11-02','Femenino','042987654','maria.gomez@mail.com','Calle 10 de Agosto 123','Guayaquil','Guayas','Activo');

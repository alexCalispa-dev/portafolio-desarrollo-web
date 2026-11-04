<?php
// Conexión a la base de datos
class Conexion
{
    private static $host = "localhost";
    private static $bd = "tienda";
    private static $usuario = "root";
    private static $clave = "";          // cambie si su MySQL tiene contraseña

    public static function conectar()
    {
        try {
            $pdo = new PDO(
                "mysql:host=" . self::$host . ";dbname=" . self::$bd . ";charset=utf8mb4",
                self::$usuario,
                self::$clave
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}

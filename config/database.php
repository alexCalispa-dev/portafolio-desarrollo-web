<?php
// Configuración de la base de datos
class Database
{
    const HOST = 'localhost';
    const BD = 'sistema_empresa';
    const USUARIO = 'root';
    const CLAVE = '';             // cambie si su MySQL tiene contraseña

    // $conBase = false -> se conecta solo al servidor (sirve para crear la base de datos)
    public static function conectar($conBase = true)
    {
        try {
            $dsn = "mysql:host=" . self::HOST . ";charset=utf8mb4";
            if ($conBase) {
                $dsn .= ";dbname=" . self::BD;
            }
            $pdo = new PDO($dsn, self::USUARIO, self::CLAVE);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}

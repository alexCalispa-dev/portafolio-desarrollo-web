<?php
require_once __DIR__ . '/../config/Conexion.php';

// MODELO Provincia: una provincia tiene muchos cantones
class Provincia
{
    private $id_provincia;
    private $nombre;
    private $extension;
    private $numero_cantones;
    private $errores = [];

    private static $campos = ['id_provincia', 'nombre', 'extension', 'numero_cantones'];

    public function __construct(array $datos = [])
    {
        foreach (self::$campos as $campo) {
            $this->$campo = trim($datos[$campo] ?? '');
        }
    }

    // Permite leer los atributos privados: $provincia->nombre
    public function __get($campo)
    {
        return $this->$campo;
    }

    public function getErrores()
    {
        return $this->errores;
    }

    // VALIDACIONES
    public function validar()
    {
        $this->errores = [];

        if ($this->nombre === '') {
            $this->errores['nombre'] = 'El nombre es obligatorio';
        } elseif (mb_strlen($this->nombre) > 50) {
            $this->errores['nombre'] = 'El nombre no puede tener más de 50 caracteres';
        }

        if (!is_numeric($this->extension) || $this->extension <= 0) {
            $this->errores['extension'] = 'La extensión debe ser un número mayor a 0';
        }

        if (!ctype_digit($this->numero_cantones)) {
            $this->errores['numero_cantones'] = 'El número de cantones debe ser un número entero';
        }

        return empty($this->errores);
    }

    // CREATE
    public function crear()
    {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("INSERT INTO provincias (nombre, extension, numero_cantones) VALUES (?, ?, ?)");
        $stmt->execute([$this->nombre, $this->extension, $this->numero_cantones]);
    }

    // READ: todas
    public static function listar()
    {
        $pdo = Conexion::conectar();
        $filas = $pdo->query("SELECT * FROM provincias ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
        $provincias = [];
        foreach ($filas as $fila) {
            $provincias[] = new Provincia($fila);
        }
        return $provincias;
    }

    // READ: una por ID
    public static function buscarPorId($id)
    {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("SELECT * FROM provincias WHERE id_provincia = ?");
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ? new Provincia($fila) : null;
    }

    // UPDATE
    public function actualizar()
    {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("UPDATE provincias SET nombre = ?, extension = ?, numero_cantones = ? WHERE id_provincia = ?");
        $stmt->execute([$this->nombre, $this->extension, $this->numero_cantones, $this->id_provincia]);
    }

    // DELETE
    public function eliminar()
    {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("DELETE FROM provincias WHERE id_provincia = ?");
        $stmt->execute([$this->id_provincia]);
    }
}

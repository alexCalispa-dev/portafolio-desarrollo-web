<?php
require_once __DIR__ . '/../config/Conexion.php';

// MODELO Canton: pertenece a una provincia y tiene muchos clientes
class Canton
{
    private $id_canton;
    private $nombre;
    private $id_provincia;
    private $extension;
    private $numero_habitantes;
    private $provincia_nombre;      // viene de la relación con provincias (JOIN)
    private $errores = [];

    private static $campos = [
        'id_canton', 'nombre', 'id_provincia', 'extension', 'numero_habitantes', 'provincia_nombre'
    ];

    const SQL_BASE = "SELECT ca.*, p.nombre AS provincia_nombre
                      FROM cantones ca
                      INNER JOIN provincias p ON ca.id_provincia = p.id_provincia";

    public function __construct(array $datos = [])
    {
        foreach (self::$campos as $campo) {
            $this->$campo = trim($datos[$campo] ?? '');
        }
    }

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
            $this->errores['nombre'] = 'El nombre del cantón es obligatorio';
        } elseif (mb_strlen($this->nombre) > 50) {
            $this->errores['nombre'] = 'El nombre no puede tener más de 50 caracteres';
        }

        if ($this->id_provincia === '') {
            $this->errores['id_provincia'] = 'Seleccione una provincia';
        }

        if (!is_numeric($this->extension) || $this->extension <= 0) {
            $this->errores['extension'] = 'La extensión debe ser un número mayor a 0';
        }

        if (!ctype_digit($this->numero_habitantes)) {
            $this->errores['numero_habitantes'] = 'El número de habitantes debe ser un número entero';
        }

        return empty($this->errores);
    }

    // CREATE
    public function crear()
    {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare(
            "INSERT INTO cantones (nombre, id_provincia, extension, numero_habitantes) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$this->nombre, $this->id_provincia, $this->extension, $this->numero_habitantes]);
    }

    // READ: todos
    public static function listar()
    {
        $pdo = Conexion::conectar();
        $filas = $pdo->query(self::SQL_BASE . " ORDER BY p.nombre, ca.nombre")->fetchAll(PDO::FETCH_ASSOC);
        $cantones = [];
        foreach ($filas as $fila) {
            $cantones[] = new Canton($fila);
        }
        return $cantones;
    }

    // READ: uno por ID
    public static function buscarPorId($id)
    {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare(self::SQL_BASE . " WHERE ca.id_canton = ?");
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ? new Canton($fila) : null;
    }

    // UPDATE
    public function actualizar()
    {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare(
            "UPDATE cantones SET nombre = ?, id_provincia = ?, extension = ?, numero_habitantes = ? WHERE id_canton = ?"
        );
        $stmt->execute([$this->nombre, $this->id_provincia, $this->extension, $this->numero_habitantes, $this->id_canton]);
    }

    // DELETE
    public function eliminar()
    {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("DELETE FROM cantones WHERE id_canton = ?");
        $stmt->execute([$this->id_canton]);
    }
}

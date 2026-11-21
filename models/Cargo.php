<?php
require_once __DIR__ . '/../config/database.php';

// MODELO Cargo (generado con scaffolding.php)
class Cargo
{
    public $id_cargo;
    public $nombre;
    public $descripcion;
    public $nivel;
    public $salario_base;
    public $errores = [];

    // Campos que se llenan desde el formulario
    private static $campos = ['nombre', 'descripcion', 'nivel', 'salario_base'];
    // Campos de solo lectura que vienen de las relaciones (JOIN)
    private static $extras = [];

    const SQL_BASE = "SELECT t.* FROM cargos t";

    public function __construct(array $datos = [])
    {
        $this->id_cargo = trim($datos['id_cargo'] ?? '');
        foreach (self::$campos as $campo) {
            $this->$campo = trim($datos[$campo] ?? '');
        }
        foreach (self::$extras as $campo) {
            $this->$campo = $datos[$campo] ?? '';
        }
    }

    // VALIDACIONES
    public function validar()
    {
        $this->errores = [];

        if ($this->nombre === '') {
            $this->errores['nombre'] = 'El campo Nombre es obligatorio';
        } elseif (mb_strlen($this->nombre) > 50) {
            $this->errores['nombre'] = 'El campo Nombre no puede tener más de 50 caracteres';
        }

        if ($this->descripcion === '') {
            $this->errores['descripcion'] = 'El campo Descripción es obligatorio';
        } elseif (mb_strlen($this->descripcion) > 100) {
            $this->errores['descripcion'] = 'El campo Descripción no puede tener más de 100 caracteres';
        }

        if ($this->nivel === '') {
            $this->errores['nivel'] = 'El campo Nivel es obligatorio';
        } elseif (mb_strlen($this->nivel) > 20) {
            $this->errores['nivel'] = 'El campo Nivel no puede tener más de 20 caracteres';
        }

        if (!is_numeric($this->salario_base) || $this->salario_base < 0) {
            $this->errores['salario_base'] = 'El campo Salario base debe ser un número válido';
        }

        return empty($this->errores);
    }

    // Valores en el mismo orden que las columnas
    private function valores()
    {
        return [$this->nombre, $this->descripcion, $this->nivel, $this->salario_base];
    }

    // CREATE
    public function crear()
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare("INSERT INTO cargos (nombre, descripcion, nivel, salario_base) VALUES (?, ?, ?, ?)");
        $stmt->execute($this->valores());
    }

    // READ: todos los registros
    public static function todos()
    {
        $pdo = Database::conectar();
        $filas = $pdo->query(self::SQL_BASE . " ORDER BY t.id_cargo DESC")->fetchAll(PDO::FETCH_ASSOC);
        $lista = [];
        foreach ($filas as $fila) {
            $lista[] = new Cargo($fila);
        }
        return $lista;
    }

    // READ: un registro por ID
    public static function buscar($id)
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare(self::SQL_BASE . " WHERE t.id_cargo = ?");
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ? new Cargo($fila) : null;
    }

    // UPDATE
    public function actualizar()
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare("UPDATE cargos SET nombre = ?, descripcion = ?, nivel = ?, salario_base = ? WHERE id_cargo = ?");
        $stmt->execute(array_merge($this->valores(), [$this->id_cargo]));
    }

    // DELETE
    public function eliminar()
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare("DELETE FROM cargos WHERE id_cargo = ?");
        $stmt->execute([$this->id_cargo]);
    }
}

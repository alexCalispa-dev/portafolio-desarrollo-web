<?php
require_once __DIR__ . '/../config/database.php';

// MODELO Departamento (generado con scaffolding.php)
class Departamento
{
    public $id_departamento;
    public $nombre;
    public $ubicacion;
    public $telefono;
    public $presupuesto;
    public $errores = [];

    // Campos que se llenan desde el formulario
    private static $campos = ['nombre', 'ubicacion', 'telefono', 'presupuesto'];
    // Campos de solo lectura que vienen de las relaciones (JOIN)
    private static $extras = [];

    const SQL_BASE = "SELECT t.* FROM departamentos t";

    public function __construct(array $datos = [])
    {
        $this->id_departamento = trim($datos['id_departamento'] ?? '');
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

        if ($this->ubicacion === '') {
            $this->errores['ubicacion'] = 'El campo Ubicación es obligatorio';
        } elseif (mb_strlen($this->ubicacion) > 50) {
            $this->errores['ubicacion'] = 'El campo Ubicación no puede tener más de 50 caracteres';
        }

        if ($this->telefono === '') {
            $this->errores['telefono'] = 'El campo Teléfono es obligatorio';
        } elseif (mb_strlen($this->telefono) > 15) {
            $this->errores['telefono'] = 'El campo Teléfono no puede tener más de 15 caracteres';
        }

        if (!is_numeric($this->presupuesto) || $this->presupuesto < 0) {
            $this->errores['presupuesto'] = 'El campo Presupuesto debe ser un número válido';
        }

        return empty($this->errores);
    }

    // Valores en el mismo orden que las columnas
    private function valores()
    {
        return [$this->nombre, $this->ubicacion, $this->telefono, $this->presupuesto];
    }

    // CREATE
    public function crear()
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare("INSERT INTO departamentos (nombre, ubicacion, telefono, presupuesto) VALUES (?, ?, ?, ?)");
        $stmt->execute($this->valores());
    }

    // READ: todos los registros
    public static function todos()
    {
        $pdo = Database::conectar();
        $filas = $pdo->query(self::SQL_BASE . " ORDER BY t.id_departamento DESC")->fetchAll(PDO::FETCH_ASSOC);
        $lista = [];
        foreach ($filas as $fila) {
            $lista[] = new Departamento($fila);
        }
        return $lista;
    }

    // READ: un registro por ID
    public static function buscar($id)
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare(self::SQL_BASE . " WHERE t.id_departamento = ?");
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ? new Departamento($fila) : null;
    }

    // UPDATE
    public function actualizar()
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare("UPDATE departamentos SET nombre = ?, ubicacion = ?, telefono = ?, presupuesto = ? WHERE id_departamento = ?");
        $stmt->execute(array_merge($this->valores(), [$this->id_departamento]));
    }

    // DELETE
    public function eliminar()
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare("DELETE FROM departamentos WHERE id_departamento = ?");
        $stmt->execute([$this->id_departamento]);
    }
}

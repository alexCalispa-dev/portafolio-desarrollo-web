<?php
require_once __DIR__ . '/../config/database.php';

// MODELO Empleado (generado con scaffolding.php)
class Empleado
{
    public $id_empleado;
    public $nombre;
    public $email;
    public $id_departamento;
    public $id_departamento_texto;
    public $id_cargo;
    public $id_cargo_texto;
    public $errores = [];

    // Campos que se llenan desde el formulario
    private static $campos = ['nombre', 'email', 'id_departamento', 'id_cargo'];
    // Campos de solo lectura que vienen de las relaciones (JOIN)
    private static $extras = ['id_departamento_texto', 'id_cargo_texto'];

    const SQL_BASE = "SELECT t.*, r1.nombre AS id_departamento_texto, r2.nombre AS id_cargo_texto FROM empleados t LEFT JOIN departamentos r1 ON t.id_departamento = r1.id_departamento LEFT JOIN cargos r2 ON t.id_cargo = r2.id_cargo";

    public function __construct(array $datos = [])
    {
        $this->id_empleado = trim($datos['id_empleado'] ?? '');
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
            $this->errores['nombre'] = 'El campo Nombre completo es obligatorio';
        } elseif (mb_strlen($this->nombre) > 50) {
            $this->errores['nombre'] = 'El campo Nombre completo no puede tener más de 50 caracteres';
        }

        if ($this->email === '') {
            $this->errores['email'] = 'El campo Email es obligatorio';
        } elseif (mb_strlen($this->email) > 100) {
            $this->errores['email'] = 'El campo Email no puede tener más de 100 caracteres';
        }

        if ($this->id_departamento === '') {
            $this->errores['id_departamento'] = 'Seleccione una opción en Departamento';
        }

        if ($this->id_cargo === '') {
            $this->errores['id_cargo'] = 'Seleccione una opción en Cargo';
        }

        return empty($this->errores);
    }

    // Valores en el mismo orden que las columnas
    private function valores()
    {
        return [$this->nombre, $this->email, $this->id_departamento, $this->id_cargo];
    }

    // CREATE
    public function crear()
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare("INSERT INTO empleados (nombre, email, id_departamento, id_cargo) VALUES (?, ?, ?, ?)");
        $stmt->execute($this->valores());
    }

    // READ: todos los registros
    public static function todos()
    {
        $pdo = Database::conectar();
        $filas = $pdo->query(self::SQL_BASE . " ORDER BY t.id_empleado DESC")->fetchAll(PDO::FETCH_ASSOC);
        $lista = [];
        foreach ($filas as $fila) {
            $lista[] = new Empleado($fila);
        }
        return $lista;
    }

    // READ: un registro por ID
    public static function buscar($id)
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare(self::SQL_BASE . " WHERE t.id_empleado = ?");
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ? new Empleado($fila) : null;
    }

    // UPDATE
    public function actualizar()
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare("UPDATE empleados SET nombre = ?, email = ?, id_departamento = ?, id_cargo = ? WHERE id_empleado = ?");
        $stmt->execute(array_merge($this->valores(), [$this->id_empleado]));
    }

    // DELETE
    public function eliminar()
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare("DELETE FROM empleados WHERE id_empleado = ?");
        $stmt->execute([$this->id_empleado]);
    }
}

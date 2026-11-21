<?php
require_once __DIR__ . '/../config/database.php';

// MODELO Asignacion (generado con scaffolding.php)
class Asignacion
{
    public $id_asignacion;
    public $id_empleado;
    public $id_empleado_texto;
    public $id_proyecto;
    public $id_proyecto_texto;
    public $fecha_asignacion;
    public $horas;
    public $errores = [];

    // Campos que se llenan desde el formulario
    private static $campos = ['id_empleado', 'id_proyecto', 'fecha_asignacion', 'horas'];
    // Campos de solo lectura que vienen de las relaciones (JOIN)
    private static $extras = ['id_empleado_texto', 'id_proyecto_texto'];

    const SQL_BASE = "SELECT t.*, r1.nombre AS id_empleado_texto, r2.nombre AS id_proyecto_texto FROM asignaciones t LEFT JOIN empleados r1 ON t.id_empleado = r1.id_empleado LEFT JOIN proyectos r2 ON t.id_proyecto = r2.id_proyecto";

    public function __construct(array $datos = [])
    {
        $this->id_asignacion = trim($datos['id_asignacion'] ?? '');
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

        if ($this->id_empleado === '') {
            $this->errores['id_empleado'] = 'Seleccione una opción en Empleado';
        }

        if ($this->id_proyecto === '') {
            $this->errores['id_proyecto'] = 'Seleccione una opción en Proyecto';
        }

        if ($this->fecha_asignacion === '') {
            $this->errores['fecha_asignacion'] = 'El campo Fecha de asignación es obligatorio';
        }

        if (!ctype_digit($this->horas)) {
            $this->errores['horas'] = 'El campo Horas debe ser un número entero';
        }

        return empty($this->errores);
    }

    // Valores en el mismo orden que las columnas
    private function valores()
    {
        return [$this->id_empleado, $this->id_proyecto, $this->fecha_asignacion, $this->horas];
    }

    // CREATE
    public function crear()
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare("INSERT INTO asignaciones (id_empleado, id_proyecto, fecha_asignacion, horas) VALUES (?, ?, ?, ?)");
        $stmt->execute($this->valores());
    }

    // READ: todos los registros
    public static function todos()
    {
        $pdo = Database::conectar();
        $filas = $pdo->query(self::SQL_BASE . " ORDER BY t.id_asignacion DESC")->fetchAll(PDO::FETCH_ASSOC);
        $lista = [];
        foreach ($filas as $fila) {
            $lista[] = new Asignacion($fila);
        }
        return $lista;
    }

    // READ: un registro por ID
    public static function buscar($id)
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare(self::SQL_BASE . " WHERE t.id_asignacion = ?");
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ? new Asignacion($fila) : null;
    }

    // UPDATE
    public function actualizar()
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare("UPDATE asignaciones SET id_empleado = ?, id_proyecto = ?, fecha_asignacion = ?, horas = ? WHERE id_asignacion = ?");
        $stmt->execute(array_merge($this->valores(), [$this->id_asignacion]));
    }

    // DELETE
    public function eliminar()
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare("DELETE FROM asignaciones WHERE id_asignacion = ?");
        $stmt->execute([$this->id_asignacion]);
    }
}

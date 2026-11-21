<?php
require_once __DIR__ . '/../config/database.php';

// MODELO Proyecto (generado con scaffolding.php)
class Proyecto
{
    public $id_proyecto;
    public $nombre;
    public $fecha_inicio;
    public $presupuesto;
    public $id_departamento;
    public $id_departamento_texto;
    public $errores = [];

    // Campos que se llenan desde el formulario
    private static $campos = ['nombre', 'fecha_inicio', 'presupuesto', 'id_departamento'];
    // Campos de solo lectura que vienen de las relaciones (JOIN)
    private static $extras = ['id_departamento_texto'];

    const SQL_BASE = "SELECT t.*, r1.nombre AS id_departamento_texto FROM proyectos t LEFT JOIN departamentos r1 ON t.id_departamento = r1.id_departamento";

    public function __construct(array $datos = [])
    {
        $this->id_proyecto = trim($datos['id_proyecto'] ?? '');
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

        if ($this->fecha_inicio === '') {
            $this->errores['fecha_inicio'] = 'El campo Fecha de inicio es obligatorio';
        }

        if (!is_numeric($this->presupuesto) || $this->presupuesto < 0) {
            $this->errores['presupuesto'] = 'El campo Presupuesto debe ser un número válido';
        }

        if ($this->id_departamento === '') {
            $this->errores['id_departamento'] = 'Seleccione una opción en Departamento';
        }

        return empty($this->errores);
    }

    // Valores en el mismo orden que las columnas
    private function valores()
    {
        return [$this->nombre, $this->fecha_inicio, $this->presupuesto, $this->id_departamento];
    }

    // CREATE
    public function crear()
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare("INSERT INTO proyectos (nombre, fecha_inicio, presupuesto, id_departamento) VALUES (?, ?, ?, ?)");
        $stmt->execute($this->valores());
    }

    // READ: todos los registros
    public static function todos()
    {
        $pdo = Database::conectar();
        $filas = $pdo->query(self::SQL_BASE . " ORDER BY t.id_proyecto DESC")->fetchAll(PDO::FETCH_ASSOC);
        $lista = [];
        foreach ($filas as $fila) {
            $lista[] = new Proyecto($fila);
        }
        return $lista;
    }

    // READ: un registro por ID
    public static function buscar($id)
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare(self::SQL_BASE . " WHERE t.id_proyecto = ?");
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ? new Proyecto($fila) : null;
    }

    // UPDATE
    public function actualizar()
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare("UPDATE proyectos SET nombre = ?, fecha_inicio = ?, presupuesto = ?, id_departamento = ? WHERE id_proyecto = ?");
        $stmt->execute(array_merge($this->valores(), [$this->id_proyecto]));
    }

    // DELETE
    public function eliminar()
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare("DELETE FROM proyectos WHERE id_proyecto = ?");
        $stmt->execute([$this->id_proyecto]);
    }
}

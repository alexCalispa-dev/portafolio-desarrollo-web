<?php
require_once __DIR__ . '/../config/Conexion.php';

// MODELO: representa al cliente y ejecuta el CRUD sobre la tabla clientes
class Cliente
{
    private $id_cliente;
    private $cedula;
    private $nombres;
    private $apellidos;
    private $fecha_nacimiento;
    private $genero;
    private $telefono;
    private $email;
    private $direccion;
    private $ciudad;
    private $provincia;
    private $estado;
    private $fecha_registro;

    // Recibe un arreglo con los datos (por ejemplo $_POST o una fila de la BD)
    public function __construct(array $datos = [])
    {
        foreach (get_object_vars($this) as $campo => $valor) {
            $this->$campo = $datos[$campo] ?? null;
        }
    }

    // Permite leer los atributos privados: $cliente->nombres
    public function __get($campo)
    {
        return $this->$campo;
    }

    // Los 11 datos que se guardan desde el formulario
    private function parametros()
    {
        return [
            $this->cedula, $this->nombres, $this->apellidos, $this->fecha_nacimiento,
            $this->genero, $this->telefono, $this->email, $this->direccion,
            $this->ciudad, $this->provincia, $this->estado
        ];
    }

    // CREATE
    public function crear()
    {
        $pdo = Conexion::conectar();
        $sql = "INSERT INTO clientes
                    (cedula, nombres, apellidos, fecha_nacimiento, genero, telefono,
                     email, direccion, ciudad, provincia, estado)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($this->parametros());
    }

    // READ: todos los clientes
    public static function listar()
    {
        $pdo = Conexion::conectar();
        $filas = $pdo->query("SELECT * FROM clientes ORDER BY id_cliente DESC")
                     ->fetchAll(PDO::FETCH_ASSOC);

        $clientes = [];
        foreach ($filas as $fila) {
            $clientes[] = new Cliente($fila);
        }
        return $clientes;
    }

    // READ: un cliente por ID
    public static function buscarPorId($id)
    {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ? new Cliente($fila) : null;
    }

    // UPDATE
    public function actualizar()
    {
        $pdo = Conexion::conectar();
        $sql = "UPDATE clientes SET
                    cedula = ?, nombres = ?, apellidos = ?, fecha_nacimiento = ?,
                    genero = ?, telefono = ?, email = ?, direccion = ?,
                    ciudad = ?, provincia = ?, estado = ?
                WHERE id_cliente = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_merge($this->parametros(), [$this->id_cliente]));
    }

    // DELETE
    public function eliminar()
    {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("DELETE FROM clientes WHERE id_cliente = ?");
        $stmt->execute([$this->id_cliente]);
    }
}

<?php
require_once __DIR__ . '/../config/Conexion.php';

// MODELO Cliente: pertenece a un cantón (y por el cantón, a una provincia)
class Cliente
{
    private $id_cliente;
    private $cedula;
    private $nombres;
    private $apellidos;
    private $fecha_nacimiento;
    private $edad;
    private $genero;
    private $telefono;
    private $email;
    private $direccion;
    private $id_canton;
    // vienen de la relación con cantones y provincias (JOIN)
    private $id_provincia;
    private $canton_nombre;
    private $provincia_nombre;
    private $errores = [];

    private static $campos = [
        'id_cliente', 'cedula', 'nombres', 'apellidos', 'fecha_nacimiento', 'edad', 'genero',
        'telefono', 'email', 'direccion', 'id_canton', 'id_provincia', 'canton_nombre', 'provincia_nombre'
    ];

    const SQL_BASE = "SELECT c.*, ca.id_provincia, ca.nombre AS canton_nombre, p.nombre AS provincia_nombre
                      FROM clientes c
                      INNER JOIN cantones ca ON c.id_canton = ca.id_canton
                      INNER JOIN provincias p ON ca.id_provincia = p.id_provincia";

    // Recibe un arreglo con los datos (por ejemplo $_POST o una fila de la BD)
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

        if ($this->nombres === '') {
            $this->errores['nombres'] = 'Los nombres son obligatorios';
        } elseif (mb_strlen($this->nombres) > 50) {
            $this->errores['nombres'] = 'Los nombres no pueden tener más de 50 caracteres';
        }

        if ($this->apellidos === '') {
            $this->errores['apellidos'] = 'Los apellidos son obligatorios';
        } elseif (mb_strlen($this->apellidos) > 50) {
            $this->errores['apellidos'] = 'Los apellidos no pueden tener más de 50 caracteres';
        }

        if ($this->fecha_nacimiento === '') {
            $this->errores['fecha_nacimiento'] = 'La fecha de nacimiento es obligatoria';
        }

        // La edad es opcional, pero si se escribe debe ser un número de hasta 3 dígitos
        if ($this->edad !== '' && (!ctype_digit($this->edad) || strlen($this->edad) > 3)) {
            $this->errores['edad'] = 'La edad debe ser un número de hasta 3 dígitos';
        }

        if ($this->email === '') {
            $this->errores['email'] = 'El email es obligatorio';
        }

        if ($this->id_canton === '') {
            $this->errores['id_canton'] = 'Seleccione una provincia y un cantón';
        }

        return empty($this->errores);
    }

    // Los 10 datos que se guardan en la tabla
    private function parametros()
    {
        return [
            $this->cedula, $this->nombres, $this->apellidos, $this->fecha_nacimiento, $this->edad,
            $this->genero, $this->telefono, $this->email, $this->direccion, $this->id_canton
        ];
    }

    // CREATE
    public function crear()
    {
        $pdo = Conexion::conectar();
        $sql = "INSERT INTO clientes
                    (cedula, nombres, apellidos, fecha_nacimiento, edad, genero, telefono, email, direccion, id_canton)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($this->parametros());
    }

    // READ: todos
    public static function listar()
    {
        $pdo = Conexion::conectar();
        $filas = $pdo->query(self::SQL_BASE . " ORDER BY c.id_cliente DESC")->fetchAll(PDO::FETCH_ASSOC);
        $clientes = [];
        foreach ($filas as $fila) {
            $clientes[] = new Cliente($fila);
        }
        return $clientes;
    }

    // READ: uno por ID
    public static function buscarPorId($id)
    {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare(self::SQL_BASE . " WHERE c.id_cliente = ?");
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ? new Cliente($fila) : null;
    }

    // UPDATE
    public function actualizar()
    {
        $pdo = Conexion::conectar();
        $sql = "UPDATE clientes SET
                    cedula = ?, nombres = ?, apellidos = ?, fecha_nacimiento = ?, edad = ?,
                    genero = ?, telefono = ?, email = ?, direccion = ?, id_canton = ?
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

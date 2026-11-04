<?php
require_once __DIR__ . '/../config/Conexion.php';

// MODELO: representa al cliente y se comunica con la base de datos
class Cliente
{
    private $id;
    private $nombre;
    private $apellido;
    private $telefono;
    private $email;

    public function __construct($nombre = "", $apellido = "", $telefono = "", $email = "", $id = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
        $this->email = $email;
    }

    // Getters
    public function getId()       { return $this->id; }
    public function getNombre()   { return $this->nombre; }
    public function getApellido() { return $this->apellido; }
    public function getTelefono() { return $this->telefono; }
    public function getEmail()    { return $this->email; }

    // CREATE
    public function crear()
    {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare(
            "INSERT INTO clientes (nombre, apellido, telefono, email) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$this->nombre, $this->apellido, $this->telefono, $this->email]);
        $this->id = $pdo->lastInsertId();
    }

    // READ: todos
    public static function listar()
    {
        $pdo = Conexion::conectar();
        $filas = $pdo->query("SELECT * FROM clientes ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
        $clientes = [];
        foreach ($filas as $f) {
            $clientes[] = new Cliente($f['nombre'], $f['apellido'], $f['telefono'], $f['email'], $f['id']);
        }
        return $clientes;
    }

    // READ: uno por ID
    public static function buscarPorId($id)
    {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
        $f = $stmt->fetch(PDO::FETCH_ASSOC);
        return $f ? new Cliente($f['nombre'], $f['apellido'], $f['telefono'], $f['email'], $f['id']) : null;
    }

    // UPDATE
    public function actualizar()
    {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare(
            "UPDATE clientes SET nombre=?, apellido=?, telefono=?, email=? WHERE id=?"
        );
        $stmt->execute([$this->nombre, $this->apellido, $this->telefono, $this->email, $this->id]);
    }

    // DELETE
    public function eliminar()
    {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = ?");
        $stmt->execute([$this->id]);
    }
}

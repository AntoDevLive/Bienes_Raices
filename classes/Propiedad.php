<?php

namespace App;

class Propiedad
{

    //Base de datos
    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'descripcion', 'habitaciones', 'wc', 'estacionamientos', 'vendedores_id', 'imagen', 'creado'];

    //Errores
    protected static $errores = [];

    public $id;
    public $titulo;
    public $precio;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamientos;
    public $imagen;
    public $creado;
    public $vendedores_id;

    //Definir conexión a la BD
    public static function setDB($database)
    {
        self::$db = $database;
    }

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamientos = $args['estacionamientos'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }

    //Insertar valores en la BD
    public function guardar()
    {

        //Sanitizar entrada de datos
        $atributos = $this->sanitizarDatos();

        $query = "INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamientos, vendedores_id, imagen, creado) 
        VALUES (
            '{$atributos['titulo']}', 
            '{$atributos['precio']}', 
            '{$atributos['descripcion']}', 
            '{$atributos['habitaciones']}', 
            '{$atributos['wc']}', 
            '{$atributos['estacionamientos']}', 
            '{$atributos['vendedores_id']}', 
            '{$atributos['imagen']}', 
            '{$atributos['creado']}'
        )";

        self::$db->query($query);
    }

    //Identificar y unir los atributos que mapean las columnas de la BD
    public function atributos()
    {
        $atributos = [];
        foreach (self::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarDatos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    //Validación
    public static function getErrores()
    {
        return self::$errores;
    }

    public function validar()
    {
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un título";
        }

        if (!$this->precio) {
            self::$errores[] = "Debes añadir un precio";
        }

        if (strlen($this->descripcion) < 50) {
            self::$errores[] = "La descripción debe tener al menos 50 caracteres";
        }

        if (!$this->habitaciones) {
            self::$errores[] = "Debes añadir un número de habitaciones";
        }

        if (!$this->wc) {
            self::$errores[] = "Debes añadir un número de baños";
        }

        if (!$this->estacionamientos) {
            self::$errores[] = "Debes añadir un número de estacionamientos";
        }

        if (!$this->vendedores_id) {
            self::$errores[] = "Debes elegir un vendedor";
        }

        return self::$errores;
    }

    public function setImagen($imagen)
    {
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }
}

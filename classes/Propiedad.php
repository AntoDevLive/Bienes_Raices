<?php

namespace App;

class Propiedad {

    //Base de datos
    protected static $db;

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

    public function __construct($args = []){
        $this -> id = $args['id'] ?? '';
        $this -> titulo = $args['titulo'] ?? '';
        $this -> precio = $args['precio'] ?? '';
        $this -> descripcion = $args['descripcion'] ?? '';
        $this -> imagen = $args['imagen'] ?? '';
        $this -> habitaciones = $args['habitaciones'] ?? '';
        $this -> wc = $args['wc'] ?? '';
        $this -> estacionamientos = $args['estacionamientos'] ?? '';
        $this -> creado = date('Y/m/d');
        $this -> vendedores_id = $args['vendedores_id'] ?? '';
    }

    //Insertar valores en la BD
    function guardar() {

        $query = "INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamientos, vendedores_id, imagen, creado) VALUES ('$this->titulo', '$this->precio', '$this->descripcion', '$this->habitaciones', '$this->wc', '$this->estacionamientos', '$this->vendedores_id', '$this->imagen', '$this->creado')";

        self::$db -> query($query);
    }

    //Definir conexión a la BD
    public static function setDB($database) {
        self::$db = $database;
    }

}
<?php

namespace App;

class Propiedad {
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $habitaciones;
    public $wc;
    public $estacionamientos;
    public $creado;
    public $vendedores_id;

    public function __construct($args = []){
        $this -> id = $args['id'] ?? '';
        $this -> titulo = $args['titulo'] ?? '';
        $this -> precio = $args['precio'] ?? '';
        $this -> imagen = $args['imagen'] ?? '';
        $this -> habitaciones = $args['habitaciones'] ?? '';
        $this -> wc = $args['wc'] ?? '';
        $this -> estacionamientos = $args['estacionamientos'] ?? '';
        $this -> creado = $args['creado'] ?? '';
        $this -> vendedores_id = $args['vendedores_id'] ?? '';
    }
}
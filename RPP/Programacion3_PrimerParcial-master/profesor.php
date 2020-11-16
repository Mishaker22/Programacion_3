<?php

require_once './vendor/autoload.php';
include_once './datos.php';

class Profesor {
    public $nombre;
    public $legajo;
    public $imagen;    

    public function __construct($nombre,$legajo,$imagen)
    {
        $this->nombre = $nombre ?? null;
        $this->legajo =$legajo ?? null;
        $this->imagen = $imagen ?? null;
    }

    
}

?>
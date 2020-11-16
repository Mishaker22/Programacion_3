<?php

require_once './vendor/autoload.php';
include_once './datos.php';

class Materia {
    public $nombre;
    public $cuatrimestre;
    public $id;    

    public function __construct($nombre,$cuatrimestre,$id)
    {
        $this->nombre = $nombre ?? null;
        $this->cuatrimestre =$cuatrimestre ?? null;
        $this->id = $id ?? null;
    }

    
}

?>
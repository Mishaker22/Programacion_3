<?php

require_once './vendor/autoload.php';
include_once './datos.php';

class Asignacion {
    public $legajoProfesor;
    public $idMateria;
    public $turno;    

    public function __construct($legajoProfesor,$idMateria,$turno)
    {
        $this->legajoProfesor = $legajoProfesor ?? null;
        $this->idMateria =$idMateria ?? null;
        $this->turno = $turno ?? null;
    }

    
}

?>
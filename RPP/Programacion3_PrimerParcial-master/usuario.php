<?php

require_once './vendor/autoload.php';
include_once './datos.php';

class Usuario {
    public $email;
    public $clave;

    public function __construct($email,$clave)
    {
        $this->email = $email ?? null;
        $this->clave =$clave ?? null;
    }

    
}

?>
<?php

class Profesor
{
    public $nombre; 
    public $legajo;
    public $imagen;
  


    public function __construct($nombre,$legajo)
    {
        $this->nombre = $nombre;
        $this->legajo = $legajo;

     
    }

    public function Save()
    {
       //$lista= Datos::GuardarJSON("Ventas.json",$this);
       $lista= Datos::GuardarJSON_Serializado("data/profesores.json",$this);

        return $lista;

    }

    public static function ValidarLegajoRepetido($legajo)
    {
        //$listaJson=Datos::LeerJSON("Usuarios.json");
        $listaJson=Datos::LeerJSON_Serializado("data/profesores.json");
        $retorno=false;

        if ($listaJson!=false) {
            foreach ($listaJson as $value) {
            
                if ($value->legajo == $legajo) {
                     $retorno = true;
                     break;
                }
                  
             }
        }
    
         return $retorno;

    }

  

 

}

?>
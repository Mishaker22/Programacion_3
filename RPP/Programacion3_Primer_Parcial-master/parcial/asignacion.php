<?php

class Asignacion{

    public $legajo_profesor; 
    public $id_materia;
    public $turno;
  


    public function __construct($legajo_profesor,$id_materia,$turno)
    {
        $this->legajo_profesor = $legajo_profesor;
        $this->id_materia = $id_materia;
        $this->turno = $turno;

     
    }

    public function Save()
    {
       //$lista= Datos::GuardarJSON("Ventas.json",$this);
       $lista= Datos::GuardarJSON_Serializado("data/materias-profesores.json",$this);

        return $lista;

    }

    public static function ValidarLegajoRepetido($asignacion)
    {
        //$listaJson=Datos::LeerJSON("Usuarios.json");
        $listaJson=Datos::LeerJSON_Serializado("data/materias-profesores.json");
        $retorno=false;

        if ($listaJson!=false) {
            foreach ($listaJson as $value) {
            
                if ($value->legajo_profesor == $asignacion->legajo_profesor && $value->id_materia == $asignacion->id_materia 
                && $value->turno == $asignacion->turno) {                 
                     $retorno = true;
                     break;
                }
                  
             }
        }
    
         return $retorno;

    }



}

?>
<?php
require_once './datos.php';

class Materia
{

    public $nombre;
    public $cuatrimestre;
    public $id;
 

    public function __construct($nombre,$cuatrimestre)
    {
        $this->nombre = $nombre;
        $this->cuatrimestre = $cuatrimestre;
        $this->id = Materia::CalcularId();
  
    }

    public function Save()
    {
       //$lista= Datos::GuardarJSON("Productos.json",$this);
        $lista= Datos::GuardarJSON_Serializado("data/materias.json",$this);

        return $lista;

    }


    public static function CalcularId()
    {
        //$lista= Datos::LeerJSON("Usuarios.json");
        $lista= Datos::LeerJSON_Serializado("data/materias.json");
        $id;

        if($lista==false)
        {
            $id=1;
        }
        else {
            $id=count($lista)+1;
        }

        return $id;

    }

    public static function ValidarMateriaRepetida($id)
    {
        //$listaJson=Datos::LeerJSON("Usuarios.json");
        $listaJson=Datos::LeerJSON_Serializado("data/materias.json");
        $retorno=false;

        if ($listaJson!=false) {
            foreach ($listaJson as $value) {
            
                if ($value->id == $id) {
                     $retorno = true;
                     break;
                }
                  
             }
        }
    
         return $retorno;

    }

 

}

?>
<?php
require_once '../ModeloParcial/manejoArchivos.php';
class Materia
{
    public $nombre;
    public $cuatrimestre;
    public $id;

    public function __construct($nombre,$cuatrimestre)
    {
        $this->nombre = $nombre;
        $this->cuatrimestre = $cuatrimestre;
        $this->id = Materia::AsignarId(); 
    }
    //Metodo magicos
    public function __get($var)
    {
        return $this->$var;
    }
    public function __set($var, $value)
    {
        $this->$var=$value;
    }
    public  function Save()
    {
        $listaMateterias=Archivos::GuardarJson("archivosGuardados/materias.json",$this);
        return $listaMateterias;
    }
    public static function AsignarId()
    {
        $listaMateterias=Archivos::TraerJson("archivosGuardados/materias.json");
        $id;
        if($listaMateterias==false)
        {
            $id=1;
        }else
        {
            $id=count($listaMateterias)+1;
        }
        return $id;
    } 
    public static function ValidarMateriaRepetida($id)
    {
        $listaMateterias=Archivos::TraerJson("archivosGuardados/materias.json");
        $retorno=false;
        if($listaMateterias != false)
        {
            foreach($listaMateterias as $value)
            {
                if($value->id == $id)
                {
                    $retorno= true;
                    break;
                }
            }
        }
        return $retorno;
    }
}

?>
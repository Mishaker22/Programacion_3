<?php
require_once '../ModeloParcial/manejoArchivos.php';
class Profesor
{
    public $nombreDocente;
    public $legajo;

    public function __construct($_nombreDocente, $_legajo)
    {
        $this->nombreDocente=$_nombreDocente;
        $this->legajo=$_legajo;
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

    public static function ValidarLegajoRepetido($legajo)
    {
        $lista= Archivos::TraerJson("archivosGuardados/profesor.json");
        $retorno=false;

        if($lista != false)
        {
            foreach($lista as $value)
            {
                if($value->legajo==$legajo)
                {
                    $retorno=true;
                    break;
                }
            }
        }
        return $retorno;
    }
    public function Save()
    {
        $listaDocentes=Archivos::GuardarJson("archivosGuardados/profesor.json",$this);
        return $listaDocentes;
    }
}
?>
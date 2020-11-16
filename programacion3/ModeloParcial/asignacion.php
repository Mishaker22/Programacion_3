<?php
require_once '../ModeloParcial/manejoArchivos.php';

class Asignacion
{
    public $legajoDocente;
    public $idMateria;
    public $turno=array('mañana', 'noche');

    public function __construct($_legajo, $_idMateria, $_turno)
    {
        $this->legajoDocente=$_legajo;
        $this->idMateria=$_idMateria;
        $this->turno=$_turno;
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
    public  function Asignarturno($turno)
    {
        switch($turno)
        {
            case 'mañana':
            $turno="mañana";
            break;
            case 'noche':
            $turno="noche";
            break;
        }
        return $turno;
    }
    public function Save()
    {
        $lista=Archivos::GuardarJson("archivosGuardados/materias-profesores.json", $this);
        return $lista;
    }

    public static function ValidarAsignacionRepetida($asignacion)
    {
        $lista=Archivos::TraerJson("archivosGuardados/materias-profesores.json");
        $retorno=false;
        
        if($lista!=false)
        {
            foreach($lista as $value)
            {
                if($value->legajoDocente == $asignacion->legajoDocente && $value->idMateria==$asignacion->idMateria && $value->turno==$asignacion->turno)
                {
                    $retorno=true;
                    break;
                }
            }
        }
        return $retorno;
    }
}
?>
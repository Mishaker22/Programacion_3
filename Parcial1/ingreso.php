<?php
class Servicio
{
    public $nombre;
    public $id;
    public $precio;
    public $demora;
    public $tipo;

    public function __construct($nombre, $id, $tipo, $precio, $demora)
    {
        $this->nombre=$nombre;
        $this->id=$id;
        $this->precio=$precio;
        $this->demora=$demora;
        $this->tipo=$tipo;
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
    public function Save($servicio)
    {
        
        $lista= Archivos::GuardarJson("archivosGuardados/tipoServicio.json",$servicio);
        Respuesta::MostrarRespuestas("EXITO", "Se guardo el archivo con exito");
        
        return $lista;
    }
    
}
?>
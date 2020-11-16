<?php
require_once '../Parcial1/respuestas.php';
class Auto
{

    public $marca;
    public $patente;
    public $modelo;
    public $precio;

    function __construct($marca, $patente, $modelo, $precio)
    {
        $this->marca = $marca;
        $this->patente = $patente;
        $this->modelo = $modelo;
        $this->precio = $precio;
    }
    /* Métodos mágicos */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }
    public  function Save($patente)
    {
        $respuesta=new Respuesta();
        $retorno=null;
        if (Auto::ValidarPatenteRepetida($patente)==false)
        {
            $lista= Archivos::GuardarJson("archivosGuardados/autos.json",$this);
            Respuesta::MostrarRespuestas($respuesta->estado, "Se guardo el archivo con exito");
            
            $retorno=$lista;
        }else
        {
            Respuesta::MostrarRespuestas("ERROR", "PATENTE REPETIDA!. La patente ya fue registrada");
        }
        return $retorno;
    }
    public static function SaveModificada($auto)
    {
        $lista= Archivos::GuardarJson("archivosGuardados/autos.json",$auto);
        $retorno=$lista;
        return $retorno;
    }
    public static function ValidarPatenteRepetida($patente)
    { 
        $listaJson=Archivos::TraerJson("archivosGuardados/autos.json");
        $retorno=false;
        
        if ($listaJson!=false) {
            foreach ($listaJson as $value) {
            
                if ($value->patente == $patente) {
                     $retorno = true;
                     break;
                }
                  
             }
        } 

         return $retorno;

    }

    public static function ExistePatente($patente)
    { 
        $listaJson=Archivos::TraerJson("archivosGuardados/autos.json");
        $retorno="No existe la patente";
        
        if ($listaJson!=false) {
            foreach ($listaJson as $value) {
            
                if ($value->patente == $patente) {
                     $retorno = $value;
                     break;
                }
                  
             }
        }   
         return $retorno;

    }
    public static function ConvertirCadena($auto)
    {
        $palabra=strtolower($auto);
        return $palabra;
    }

    public static function ExisteVehiculo($buscador)
    { 
        $listaJson=Archivos::TraerJson("archivosGuardados/autos.json");
        $retorno="No existe el vehiculo";
        
        if ($listaJson!=false) {
            foreach ($listaJson as $value) {
            
                if ($value->patente == $buscador) 
                {
                     $retorno = $value;
                     break;
                }elseif($value->modelo == $buscador)
                {
                    $retorno = $value;
                     break;
                }elseif($value->marca == $buscador)
                {
                    
                    $retorno = $value;
                     break;
                }
                  
             }
        }   
         return $retorno;

    }
    public static function SiExisteVehiculo($buscador)
    { 
        $listaJson=Archivos::TraerJson("archivosGuardados/autos.json");
        $retorno=false;
        
        if ($listaJson!=false) {
            foreach ($listaJson as $value) {
            
                if ($value->patente == $buscador) 
                {
                     $retorno = true;
                     break;
                }elseif($value->modelo == $buscador)
                {
                    $retorno = true;
                     break;
                }elseif($value->marca == $buscador)
                {
                    
                    $retorno = true;
                     break;
                }
                  
             }
        }   
         return $retorno;

    }
    public static function CalcularImporte($horaEgreso, $patente)
    {
        $lista=Archivos::TraerJson("archivosGuardados/autos.json");
        if($lista !=false)
        {
            if($auto=Auto::ExistePatente($patente))
            {
                $hIngreso=new DateTime($auto->date);
                $hSalida=new DateTime($horaEgreso);
                $intervalo=$hIngreso->diff($hSalida);
                
                $diff_minute = $intervalo->format('%i'); // minutos
                $diff_minute += $intervalo->format('%h')*60;  // horas
                $diff_minute += $intervalo->format('%a')*1440; // dias
                var_dump($diff_minute);
                
                if($diff_minute < 240)
                {
                    $auto->importe=100;
                    $importe=$auto->importe;
                }elseif($diff_minute > 240 && $diff_minute < 720)
                {
                    $auto->importe=60;
                    $importe=$auto->importe;
                }elseif($diff_minute > 720)
                {
                    $auto->importe=100;
                    $importe=$auto->importe;
                }
                
                
            }
        }
        return $importe;
    }
   


    
}

?>
<?php
require_once '../Parcial1/respuestas.php';
class Archivos
{
    public static function Serializacion($ruta, $objeto)
    {
        $listaPrevia=Archivos::TraerSerializacion($ruta);
        $b=false;
        foreach($listaPrevia as $datos)
        {
            if($auto->_patente==$objeto->_patente)
            {
                $b=true;
            }     
        }
        if($b==false)
            {
                echo " Se guardo correctamente."."\r\n";
                $archivo=fopen("./".$ruta,"a");
                fwrite($archivo,serialize($objeto)."\r\n"); //Serializa el objeto
                fclose($archivo);
            }else
            {
                echo "este objeto ya existe"."\r\n";
            }
        
    }
    public static function TraerSerializacion($ruta)
    {
        $lista=array();
        $archivo=fopen("./".$ruta,"r");
        while (!feof($archivo))
        {
            $objeto=unserialize(fgets($archivo));
            if($objeto != null)
            {
                array_push($lista,$objeto);
            }
        }
        fclose($archivo);
        return $lista;
    }
    public static function GuardarJson($ruta,$objeto)
    {
        $array=Archivos::TraerJson($ruta); 
        if(isset($array))
        {
            $archivo=fopen("./".$ruta, "w");
            array_push($array, $objeto);
            fwrite($archivo,json_encode($array));
            fclose($archivo);
        }else{
            $array2=array();
            $archivo=fopen("./".$ruta, "w");
            array_push($array2, $objeto);
            fwrite($archivo,json_encode($array2));
            fclose($archivo);
        }
    }
    public static function TraerJson($ruta)
    {
        if(file_exists($ruta))
        {
            $archivo=fopen($ruta, "r");
            $lista=json_decode(fgets($archivo));
            fclose($archivo);
            if(isset($lista))
            {
                return $lista;
            }else
            {
                echo "La lista esta vacia";
            }
        }else{

            echo "el archivo no existe. Creando uno nuevo","\n";
        }
    }
    public static function MostrarListasFormatoJson($ruta)
    {
        $respuesta=new Respuesta();
        $lista=Archivos::TraerJson($ruta);
        if($lista != false)
        {
            /*usort($lista,"sort_by_orden");
            function sort_by_orden($a,$b)
            {
                return$a['date']-$b['date'];
            }*/
            $respuesta->info=$lista;
            
        }else
        {
            $respuesta->info="Lista vacia";
            $respuesta->estado="ERROR";
        }
        echo json_encode($respuesta);
    }
   
}
?>
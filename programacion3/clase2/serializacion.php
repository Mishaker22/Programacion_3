<?php
require_once '../clase2/auto.php';

class Archivos
{
    static function SerializarAuto($ruta, $objeto)
    {
        $listaPrevia=Archivos::TraerSerializacion($ruta);
        $b=false;
        foreach($listaPrevia as $auto)
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
    static function TraerSerializacion($ruta)
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
    static function GuardarJson($ruta,$objeto)
    {
        $array=Archivos::TraerJson($ruta); 
        if(isset($array))
        {
            $archivo=fopen("./".$ruta, "w");
            array_push($array, $objeto);
            fwrite($archivo,json_encode($array));
            echo " Se guardo correctamente";
            fclose($archivo);
        }else{
            $array2=array();
            $archivo=fopen("./".$ruta, "w");
            array_push($array2, $objeto);
            fwrite($archivo,json_encode($array2));
            echo " Se guardo correctamente";
            fclose($archivo);
        }
    }
    static function TraerJson($ruta)
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

            echo "el archivo no existe";
        }
    }
}
?>
<?php

class Datos{

public static function Guardar($archivo,$datos,$formato)
{
    $file=fopen($archivo,$formato);

    $rta=fwrite($file,$datos);

    fclose($file);

    return $rta;

}

public static function GuardarJSON_Serializado($archivo,$objeto)
{
   
   
    $arrayJSON = Datos::LeerJSON_Serializado($archivo,$objeto);
    $auxArray=array();
    
    if ($arrayJSON==false) {
        array_push($auxArray,$objeto);
       $rta =Datos::Guardar($archivo,serialize($auxArray),"w");
    }
    else {
        array_push($arrayJSON,$objeto);

        $rta =Datos::Guardar($archivo,serialize($arrayJSON),"w");
    }

    return $rta;

}

public static function LeerJSON_Serializado($archivo)
{
    $file=fopen($archivo,"a+");

    $arrayString = fgets($file);
    
    $arrayJSON = unserialize($arrayString);
 
    fclose($file);

    return$arrayJSON;

}



public static function GuardarFoto($name,$tmp_name,$id)
{
   $folder ="imagenes/";
   $name_Array= explode('.', $name);
   $indice= Datos::ultimondice($name_Array);

   $nombre = $id . '-' . time() . '.' . $name_Array[$indice];

   move_uploaded_file($tmp_name,$folder.$nombre);

    return $folder.$nombre;
}

public static function ultimondice($array)
{
    return array_key_last($array);
}


}

?>
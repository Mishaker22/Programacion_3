<?php


require_once '../clase2/auto.php';

$listaDeAutos=array();
$auto=new Auto('AMI 52','SUSUKI','NIGGA',350000);
$file='archivo.txt';
$modo='r';

//copy($file,'probandoLaCopia.txt');-->Copia el archivo
//unlink('probandoLaCopia.txt');//borra el archivo
$archivo=fopen($file, $modo);


//$sizeFile=filesize($file);//Da el tamaño exacto del archivo

//$fwrite=fwrite($archivo, $auto."\r\n");

//echo "fwrite $fwrite <br>";
while(!feof($archivo))
{
    $linea=fgets($archivo);//lee linea por linea;
    $datos=explode('*',$linea);//cuenta los espacion comoasteriscos
    if(count($datos)>3)
    {
        $nuevoAuto=new Auto($datos[0],$datos[1],$datos[2],$datos[3]);
        array_push($listaDeAutos,$nuevoAuto);
    }
    echo $linea;
}
//$fread=fread($archivo,$sizeFile);-->leer un archivo
//echo $fread;//LECTURA
$close=fclose($archivo);
//var_dump($listaDeAutos);
foreach($listaDeAutos as $value)
{
    echo $value->_patente;
}

?>
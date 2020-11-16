<?php

/*Obtenga la fecha actual del servidor (función date) y luego imprímala dentro de la página con
distintos formatos (seleccione los formatos que más le guste). Además indicar que estación del
año es. Utilizar una estructura selectiva múltiple.*/

$bisiesto=date('L');
$dia=date('z');
$invierno=172;
$primavera=264;
$verano=354;
$otoño=79;

$fecha=date(" j F, Y, g:i a");
echo "$fecha Estacion: ";
if($bisiesto==1)
{
    $invierno=173;
    $primavera=265;
    $verano=356;
    $otoño=80;
}
if($dia > $invierno)
{
    echo" Invierno ";
}elseif($dia > $primavera)
{
    echo "Primavera";
}elseif($dia > $verano)
{
    echo " Verano ";
}elseif($dia > $otoño)
{
    echo "Otoño";
}else{
    echo " Verano";
}
?>
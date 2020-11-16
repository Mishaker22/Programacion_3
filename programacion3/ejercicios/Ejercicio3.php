<?php
/*Dadas tres variables numéricas de tipo entero $a, $b y $c realizar una aplicación que muestre
el contenido de aquella variable que contenga el valor que se encuentre en el medio de las tres
variables. De no existir dicho valor, mostrar un mensaje que indique lo sucedido.
Ejemplo 1: $a = 6; $b = 9; $c = 8; => se muestra 8.
Ejemplo 2: $a = 5; $b = 1; $c = 5; => se muestra un mensaje “No hay valor del medio”*/

$flag=true;
$array=array("a"=>5,"b"=>100,"c"=>100);

sort($array, SORT_REGULAR);
if($array[0]==$array[1]||$array[0]==$array[2]||$array[2]==$array[1])
{
    echo" No hay valor en el medio";
}else
{
     echo $array[1];  
}

?>
<?php
/*Confeccionar un programa que sume todos los numeros enteros desde 1 mientras la suma no supere a 1000
Mostrar los numeros sumados y al finalizar el proceso, indicar cuantos numeros de sumaron;
*/
$suma=0;
$numero=1;

while($suma+$numero<1000)
{
    $numero++;
    echo "$suma+$numero = ",
    $suma += $numero;
    echo "<br/>";

}
echo "Se sumaron $numero numeros."
?>
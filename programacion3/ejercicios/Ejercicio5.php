<?php
/*Realizar un programa que en base al valor numérico de una variable $num, pueda mostrarse
por pantalla, el nombre del número que tenga dentro escrito con palabras, para los números
entre el 20 y el 60.
Por ejemplo, si $num = 43 debe mostrarse por pantalla “cuarenta y tres”.*/

$num = 22;
$decena = (int) ($num / 10);
$unidades = $num % 10;
$resultado = "";
 
switch ($decena) {
    case '2':
        $resultado .= 'Veinte';
    break;
 
    case '3':
        $resultado .= 'Treinta';
    break;
 
    case '4':
        $resultado .= 'Cuarenta';
    break;
 
    case '5':
        $resultado .= 'Cincuenta';
    break;
 
    case '6':
        $resultado .= 'Sesenta';
    break;
}
 
switch ($unidades) {
    case '1':
        $resultado .= ' y uno';
    break;
 
    case '2':
        $resultado .= ' y dos';
    break;
 
    case '3':
        $resultado .= ' y tres';
    break;
 
    case '4':
        $resultado .= ' y cuatro';
    break;
 
    case '5':
        $resultado .= ' y cinco';
    break;
 
    case '6':
        $resultado .= ' y seis';
    break;
 
    case '7':
        $resultado .= ' y siete';
    break;
 
    case '8':
        $resultado .= ' y  ocho';
    break;
 
    case '9':
        $resultado .= ' y nueve';
    break;
}
 
echo $resultado.'<br />';

?>
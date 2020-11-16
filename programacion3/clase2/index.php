<?php
require_once '../clase2/auto.php';
require_once '../clase2/serializacion.php';
require_once '../clase2/file.php';
/**
 * METODOS
 * GET: Obtener recursos
 * POST:Crear recursos
 * PUT: Modificar recursos
 * DELETE: Borrar recursos
 */
//var_dump($_SERVER);
$method=$_SERVER['REQUEST_METHOD'];
$path=$_SERVER['PATH_INFO']??0;

switch($path)
{
    case '/auto':
        switch($method)
        {
            case 'POST':
                //var_dump($_POST);//se hace por body
                $patente=$_POST['patente']??"";
                $marca = $_POST['marca']??"";
                $color = $_POST['color']??"";
                $precio = $_POST['precio']??'a';
                if(strlen($patente)>4 && strlen($patente)<8 && strlen($marca)>0 && strlen($color)>0)
                {
                    $auto= new Auto($patente,$marca,$color);
                    //Archivos::SerializarAuto("autoSerializados.txt",$auto);//SERIALIZACION NORMAL
                    Archivos::GuardarJson("autoJson.txt",$auto);//SERIALIZACION CON JSON ATRIBUTOS PUBLICOS SI O SI

                }else
                {
                    echo "Ingrese correctamente patente, marca, color."."\r\n";
                }

            break;
            case 'GET':
                //var_dump($_GET);//se hace por params en postman
                $b=false;
                $patente2= $_GET['buscar']??'';
                //$arrayAutosSerializados=Archivos::TraerSerializacion("autoSerializados.txt");//->DESERIALIZADO NORMAL
                $arrayJson=Archivos::TraerJson("autoJson.txt");
                if(strlen($patente2)>4 && strlen($patente2)<8)
                {
                    foreach($arrayJson as $a)
                    {
                        if($a->_patente==$patente2)
                        {
                            echo "  Se encontro"."\r\n";
                            //var_dump($a);
                            echo $a->_patente." color: ".$a->_color." marca: ".$a->_marca."\r\n";
                            $b=true;
                        }
                    }
                }
                if($b==false)
                {
                    echo "No se encontro ningun auto con esa patente"."\r\n";
                }
                /*$patente = $_GET['patente']??"";
                $marca = $_GET['marca']??"";
                $color = $_GET['color']??"";
                $precio = $_GET['precio']??0; //<-- esto*/
                //$auto= new Auto($patente,$marca,$color,$precio);
                //$auto->_marca='Susuki';--->Setear
                //echo "<br>";
                //echo $auto->_marca;-->Lo que retorna
                //echo $auto->_marca;
            break;
        }
    break;
    case 'user':
    break;
    default:
    echo "path Erroneo!";
}

echo $method. "<br>". $path ."<br>";


/*if(isset($_GET['precio']))
{
    $precio = $_GET['precio'];
}---->esto es equivalente a 
else
{
    $precio=0;
}*/

?>
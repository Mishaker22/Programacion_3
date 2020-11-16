<?php
//require_once '../clase4/upload.php';
$method=$_SERVER['REQUEST_METHOD'];
$path=$_SERVER['PATH_INFO']??0;

switch($path)
{
    case '/upload':
        switch($method)
        {
            case 'POST':
                echo"entro post";
                $imagen=$_FILES["imagen"]['name']??null;
                $temp=$_FILES["imagen"]["tmp_name"]??null;
                if(isset($imagen))
                {
                //$subir=Upload::Init($imagen,$temp);
                //echo"Archivo guardado";
                    include_once("upload.php"); 
                    $subir = new Upload;
                    // Inicializamos
                    $subir->init($imagen,$temp);
                }else
                {
                    echo"Debe completar los campos";
                }

            break;
        }
    break;
}
?>

<?php

use \Firebase\JWT\JWT;

require_once './vendor/autoload.php';
require_once './usuario.php';
require_once './datos.php';
require_once './auth.php';
require_once './materia.php';
require_once './profesor.php';
require_once './asignacion.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '';
$key = 'pro3-parcial';
$usuarios = array();
$materias = array();
$profesores = array();
$asignaciones = array();

switch ($path) {
    case '/usuario':
        switch ($method) {
            case 'POST':
                
                $email = $_POST['email'];
                $clave = $_POST['clave'];

                if(isset($email) && isset($clave)) {
                        
                    if(!empty($email) && !empty($clave))
                    {
                        $usuario = new Usuario($email,$clave);
                        $usuarios = Datos::leerJson('users.json'); 

                        if($usuarios == false)
                        {
                            $usuarios = array();
                            array_push($usuarios,$usuario);
                            $usuarios = Datos::guardarUno('users.json',$usuarios);
                            } else {
                                $usuarios = Datos::guardarJson('users.json',$usuario); 
                            }
                        }
                        else 
                        {
                            echo 'Tipo de cliente no valido';
                        }
                } else {
                    echo "Error, faltan datos";
                }
                break;
            
            default:
                echo "Metodo no soportado";
                break;
        }
        break;
    case '/login':
        switch ($method) {
            case 'POST':
                $email = $_POST['email'];
                $clave = $_POST['clave'];

                if(isset($email) && isset($clave)) {
                    $_SESSION['Usuario'] = Auth::login($email,$clave,$key);
                    var_dump($_SESSION['Usuario']);
                    if(!$_SESSION['Usuario'])
                    {
                        echo "Combinacion Email/Clave Incorrectos";
                    }
                } else
                {
                    echo "Debe cargar Email y Clave para ingresar";
                }
            break;
            
            default:
                echo "Metodo no soportado";
                break;
        }
    break;

    case '/materia' :
        switch ($method) {
            case 'POST':
                $decoded = Auth::decodeToken('token',$key);

                if($decoded)
                {
                    $id = strval(rand(1,100));
                    $nombre = $_POST['nombre'];
                    $cuatrimestre = $_POST['cuatrimestre'];
    
                    if(isset($nombre) && isset($cuatrimestre) && isset($id)) {
                            
                        if(!empty($nombre) && !empty($cuatrimestre) && !empty ($id))
                        {
                            $materia = new Materia($nombre,$cuatrimestre,$id);
                            $materias = Datos::leerJson('materias.json'); 
    
                            if($materias == false)
                            {
                                $materias = array();
                                array_push($materias,$materia);
                                $materias = Datos::guardarUno('materias.json',$materias);
                                echo "Cargado exitosamente".PHP_EOL;
                            } else {
                                $materias = Datos::guardarMateria('materias.json',$materia); 
                                echo "Cargado exitosamente".PHP_EOL;
                            }
                        }
                        else 
                        {
                            echo 'Materia no valida';
                        }
                    } else {
                        echo "Error, faltan datos";
                    }
                } else {
                    echo "Token incorrecto";
                }
            break;

            case 'GET':
                $decoded = Auth::decodeToken('token',$key);
                if($decoded)
                {
                    $lista = Datos::leerJSON('materias.json');
                    print_r($lista);
                }
            break;
            
            default:
                echo "Metodo no soportado";
                break;
        }

    break;

    case '/profesor' :
        switch ($method) {
            case 'POST':
                $decoded = Auth::decodeToken('token',$key);
                $profesorRepetido = false;

                $explode = explode('.', $_FILES['imagen']['name']); //separa el nombre en nombre de foto y extension
                $hora = time();
                $origen = $_FILES['imagen']['tmp_name']; //nombre carpeta temporal donde esta guardada
                $destino = './imagenes/' . $explode[0] . '_' . $hora . '.' . $explode[1];

                if($decoded)
                {
                    $legajo = $_POST['legajo'];;
                    $nombre = $_POST['nombre'];
                    $imagen = $destino;
    
                    if(isset($nombre) && isset($legajo)) {
                            
                        if(!empty($nombre) && !empty($legajo))
                        {
                            $profesores = Datos::leerJson('profesores.json');

                            $profesor = new Profesor($nombre,$legajo,$imagen);
                             
    
                            if($profesores == false)
                            {
                                $profesores = array();
                                array_push($profesores,$profesor);
                                $profesores = Datos::guardarUno('profesores.json',$profesores);
                                move_uploaded_file($origen,$destino);
                                echo "Profesor cargado con exito";
                            } else {

                                foreach ($profesores as $value) {
                                    if($value->legajo == $legajo){
                                        $profesorRepetido = true;
                                        break;
                                    }
                                }

                                if(!$profesorRepetido){

                                    $profesores=Datos::guardarProfesor('profesores.json',$profesor);
                                    move_uploaded_file($origen,$destino);
                                    echo "Profesor cargado con exito";
                                }else {
                                    echo "Profesor repetido";
                                }
                            }
                        }
                        else 
                        {
                            echo 'Profesor no valido';
                        }
                    } else {
                        echo "Error, faltan datos";
                    }
                } else {
                    echo "Token incorrecto";
                }
            break;
            
            case 'GET':
                $decoded = Auth::decodeToken('token',$key);
                if($decoded)
                {
                    $lista = Datos::leerJSON('profesores.json');
                    print_r($lista);
                }
                break;
            default:
                echo "Metodo no soportado";
                break;
        }

    break;

    case '/asignacion' :
        switch ($method) {
            case 'POST':
                $decoded = Auth::decodeToken('token',$key);
                $asignacionRepetida = false;


                if($decoded)
                {
                    $legajo = $_POST['legajo'];;
                    $idMateria = $_POST['id'];
                    $turno = $_POST['turno'];
    
                    if(isset($legajo) && isset($idMateria) && isset($turno)) {
                            
                        if(!empty($legajo) && !empty($idMateria) && !empty($turno))
                        {
                            $asignaciones = Datos::leerJson('materias-profesores.json');

                            $asignacion = new Asignacion($legajo,$idMateria,$turno);

                            if($asignaciones == false)
                            {
                                $asignaciones = array();
                                array_push($asignaciones,$asignacion);
                                $asignaciones = Datos::guardarUno('materias-profesores.json',$asignaciones);
                            }
                            else
                            {
                                foreach ($asignaciones as $value) {
                                    if($value->legajoProfesor == $legajo && $value->idMateria == $idMateria){
                                        $asignacionRepetida = true;
                                        break;
                                    }

                                }

                                if(!$asignacionRepetida){

                                    $asignaciones=Datos::guardarAsignacion('materias-profesores.json',$asignacion);
                                    echo "Asignacion cargada con exito";
                                }else {
                                    echo "Asignacion repetida";
                                }
                            }

                        }
                        else 
                        {
                            echo 'Profesor no valido';
                        }
                    } else {
                        echo "Error, faltan datos";
                    }
                } else {
                    echo "Token incorrecto";
                }
            break;

            case 'GET':
                $decoded = Auth::decodeToken('token',$key);
                if($decoded)
                {
                    $lista = Datos::leerJSON('materias-profesores.json');
                    print_r($lista);
                }
                break;
            
            default:
                echo "Metodo no soportado";
                break;
        }

    break;


    default:
        echo "Path desconocido";
        break;


}

?>
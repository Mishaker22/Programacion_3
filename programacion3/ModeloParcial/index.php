<?php

require_once '../ModeloParcial/usuario.php';
require_once '../ModeloParcial/respuestas.php';
require_once '../ModeloParcial/token.php';
require_once '../ModeloParcial/materias.php';
require_once '../ModeloParcial/profesor.php';
require_once '../ModeloParcial/asignacion.php';

$method=$_SERVER['REQUEST_METHOD'];
$path=$_SERVER['PATH_INFO']??0;
$respuesta=new Respuesta();
try
{
    $auxPath = explode('/', $path)[1];
        switch('/' . $auxPath)
    {
        case '/usuario':
            switch($method)
            {
                case 'POST':
                    $correo=$_POST['email'] ?? null;
                    $contraseña=$_POST['clave']?? null;
                    $imagen=$_FILES["imagen"]['name']??null;
                    $temp=$_FILES["imagen"]["tmp_name"]??null;
                    
                    if(isset($correo)&& isset($contraseña) && strlen($correo)>0 && strlen($contraseña)>0)
                    {
                        $usuario= new Cliente($correo,$contraseña,$imagen);
                        try
                        {
                            if(Cliente::ValidarUsuarioRepetido($correo))
                            {
                                throw new Exception(' ¡Usuario Repetido!. El Usuario ya fue registrado');
                            }
                            else
                            {
                                include_once("upload.php"); 
                                $subir = new Upload;
                                $usuario->imagen=$subir->init($imagen,$temp);
                                echo "imagen ",$usuario->imagen," ";
                                $rta=$usuario->Save($correo,$contraseña,$usuario->imagen);
                                Respuesta::MostrarRespuestas($respuesta->estado, "Se guardo el archivo con exito"); 
                            }
                        }
                        catch(Exception $e)
                        {
                            echo 'Excepcion capturada: ', $e->getMessage(), "\n";
                        }                  
                    }elseif(isset($imagen))
                    {
                        if($email=explode('/', $path)[2])
                        {
                            echo "esta: $email";
                            if(Cliente::ValidarUsuarioRepetido($email))
                            {
                                include_once("upload.php"); 
                                $obj=Cliente::DevolverUsuario($email);
                                $subir = new Upload();
                                $obj->imagen =$subir->Move();
                                $obj->imagen=$subir->init($imagen, $temp);
                                $modUser=new Cliente($obj->email,$obj->clave,$obj->imagen);
                                $rta=$modUser->Save($obj->email,$obj->clave,$obj->imagen);
                                Respuesta::MostrarRespuestas($respuesta->estado, "Se guardo el archivo con exito la nueva foto");
                            }
                        }else {
                            Respuesta::MostrarRespuestas("ERROR", "Debe cargar el correo en el path");
                        }
                        
                    }
                    else
                    {
                        Respuesta::MostrarRespuestas("ERROR"," Debe completar los campos");
                    }
                    
                    

                break;
                default:
                Respuesta::MostrarRespuestas("ERROR"," Metodo Invalido");
                break;
            }
        break;
        
        case '/login':
        
            switch($method)
            {
                case 'POST':
                    $correo=$_POST['email'] ?? null; 
                    $contraseña= $_POST['clave'] ?? null; 
                    
                    if(isset($correo)&& isset($contraseña) && strlen($correo)>0 && strlen($contraseña)>0)
                    {
                        $rta=Cliente::ValidarUsuario($correo,$contraseña);
                        Respuesta::MostrarRespuestas($respuesta->estado,$rta);
                    }else
                    {
                        Respuesta::MostrarRespuestas("ERROR"," Debe completar los campos");
                    }
                break;
                default:
                    Respuesta::MostrarRespuestas("ERROR"," Metodo Invalido");
                break;
            }
        break;
        case '/materias':
            switch($method)
            {
                case 'POST':

                    $headers=getallheaders();

                    $nombreMateria = $_POST['nombre'] ?? null; 
                    $cuatrimestre = $_POST['cuatrimestre'] ?? null;

                    $Token=$headers["token"]??"";
                    $payload = Token::ValidarToken($Token);
                    
                    if($payload != null)
                    {
                        if(isset($nombreMateria) && isset($cuatrimestre) && strlen($nombreMateria)>0 && strlen($cuatrimestre)>0)
                        {
                            $materia= new Materia($nombreMateria,$cuatrimestre);
                            $rta=$materia->Save();
                            Respuesta::MostrarRespuestas($respuesta->estado, "Se guardo el archivo con exito");           
                        }else
                        {
                            Respuesta::MostrarRespuestas("ERROR"," Debe completar los campos");
                        }
                    }else
                    {
                        Respuesta::MostrarRespuestas("ERROR", " Token Invalido!!");
                    }
                break;
                case 'GET':

                    $headers=getallheaders();
                    $Token=$headers["token"]??"";
                    $payload = Token::ValidarToken($Token);

                    if($payload !=null)
                    {
                        Archivos::MostrarListasFormatoJson("archivosGuardados/materias.json");
                    }else 
                    {
                        Respuesta::MostrarRespuestas("ERROR", " Token Invalido!!");
                    }
                break;
                default:
                Respuesta::MostrarRespuestas("ERROR", " Metodo Invalido");
                break;
            }  
        break;
        case '/profesor':
            switch($method)
            {
                case 'POST':

                    $headers=getallheaders();
                    $nombreDocente=$_POST['nombre']?? null;
                    $legajo=$_POST['legajo']?? null;
                    $Token=$headers["token"]??"";
                    $payload = Token::ValidarToken($Token);

                    if($payload !=null)
                    {
                        if(isset($nombreDocente) && isset($legajo) && strlen($nombreDocente)>0 && strlen($legajo)>0)
                        {
                            $nuevoDocente=new Profesor($nombreDocente,$legajo);
                            if(Profesor::ValidarLegajoRepetido($legajo)==false)
                            {
                                $rta=$nuevoDocente->Save();
                                Respuesta::MostrarRespuestas($respuesta->estado, "Se guardo el archivo con exito");
                            }
                            else
                            {
                                Respuesta::MostrarRespuestas("ERROR"," Legajo repetido, Intente con otro");
                            }
                        }else 
                        {
                            Respuesta::MostrarRespuestas("ERROR"," Debe completar los campos");
                        }
                    }else {
                        Respuesta::MostrarRespuestas("ERROR"," Token Invalido!!");
                    }
                break;
                case 'GET':
                    $headers=getallheaders();
                    $Token=$headers["token"]??"";
                    $payload = Token::ValidarToken($Token);

                    if($payload !=null)
                    {
                        Archivos::MostrarListasFormatoJson("archivosGuardados/profesor.json");
                        
                    }else 
                    {
                        Respuesta::MostrarRespuestas("ERROR"," Token Invalido!!");
                    }
                break;
                default:
                Respuesta::MostrarRespuestas("ERROR", " Metodo Invalido");
                break;
            }  
        break;  
        case '/asignacion':
            switch($method)
            {
                case 'POST':

                    $headers=getallheaders();
                    $LegajoDocente=$_POST['legajo']?? null;
                    $idMateria=$_POST['id']?? null;
                    $turno=$_POST['turno']?? null;
                    strtolower($turno);
                    $Token=$headers["token"]??"";
                    $payload = Token::ValidarToken($Token);
                    
                    if($payload != null)
                    {
                        if(isset($LegajoDocente)&& isset($idMateria) && isset($turno) && strlen($LegajoDocente)>0 && strlen($idMateria)>0 && strlen($turno)>0)
                        {
                            if(Asignacion::AsignarTurno($turno))
                            {
                                if(Profesor::ValidarLegajoRepetido($LegajoDocente)&& Materia::ValidarMateriaRepetida($idMateria))
                                {
                                    $asignacion=new Asignacion($LegajoDocente,$idMateria,$turno);
                                    if(Asignacion::ValidarAsignacionRepetida($asignacion)==false)
                                    {
                                        $rta=$asignacion->Save();
                                        Respuesta::MostrarRespuestas($respuesta->estado, "Se guardo el archivo con exito");
                                    }else
                                    {
                                        Respuesta::MostrarRespuestas("ERROR","No se puede guardar el mismo profesor, con la misma materia y turno");
                                    }
                                }else
                                {
                                    Respuesta::MostrarRespuestas("ERROR","El profesor o la materia no existen!");
                                }
                            }else {
                                
                                Respuesta::MostrarRespuestas("ERROR","Turnos: mañana/noche");
                            }
                        }else {
                            
                            Respuesta::MostrarRespuestas("ERROR","Debe completar los campos");
                        }
                    }else
                    {
                        Respuesta::MostrarRespuestas("ERROR"," Token Invalido!!");
                    }
                break;
                case 'GET':
                    $headers=getallheaders();
                    $Token=$headers["token"]??"";
                    $payload = Token::ValidarToken($Token);

                    if($payload !=null)
                    {
                        Archivos::MostrarListasFormatoJson("archivosGuardados/materias-profesores.json");
                    }else 
                    {
                        Respuesta::MostrarRespuestas("ERROR"," Token Invalido!!");
                    }
                break;
                default:
                Respuesta::MostrarRespuestas("ERROR", " Metodo Invalido");
                break;

            }
        break;
        default:
        Respuesta::MostrarRespuestas("ERROR", " La ruta no existe");
        break;
        
    }
}catch(Exception $e){

}



?>
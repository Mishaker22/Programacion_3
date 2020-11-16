<?php

require_once '../Parcial1/registro.php';
require_once '../Parcial1/respuestas.php';
require_once '../Parcial1/token.php';
require_once '../Parcial1/auto.php';
require_once '../Parcial1/ingreso.php';

$method=$_SERVER['REQUEST_METHOD'];
$path=$_SERVER['PATH_INFO']??0;
$respuesta=new Respuesta();
try
{
    $auxPath = explode('/', $path)[1];
        switch('/' . $auxPath)
    {
        case '/registro':
            switch($method)
            {
                case 'POST':
                    $correo=$_POST['email'] ?? null;
                    $contraseña=$_POST['password']?? null;
                    $tipo=$_POST['tipo']?? null;
                    $imagen=$_FILES["imagen"]['name']??null;
                    $temp=$_FILES["imagen"]["tmp_name"]??null;
                    
                    if(isset($correo)&& isset($contraseña) && strlen($correo)>0 && strlen($contraseña)>0 && strlen($tipo)>0)
                    {
                        $usuario= new Registro($correo,$contraseña,$imagen,$tipo);
    
                
                            if(Registro::ValidarUsuarioRepetido($correo))
                            {
            
                                Respuesta::MostrarRespuestas("ERROR", "Usuario Repetido!. El Usuario ya fue registrado"); 
                            }
                            else
                            {
                                include_once("upload.php"); 
                                $subir = new Upload;
                                $usuario->imagen=$subir->init($imagen,$temp);
                                echo "imagen ",$usuario->imagen," ";
                                $rta=$usuario->Save($correo,$contraseña,$usuario->imagen,$tipo);
                                Respuesta::MostrarRespuestas($respuesta->estado, "Se guardo el archivo con exito"); 
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
                    $contraseña= $_POST['password'] ?? null; 
                    
                    if(isset($correo)&& isset($contraseña) && strlen($correo)>0 && strlen($contraseña)>0)
                    {
                        $rta=Registro::ValidarUsuario($correo,$contraseña);
                        $usuar=Registro::DevolverUsuario($correo);
                        Respuesta::MostrarRespuestas($respuesta->estado,"Bienvenido:  $usuar->tipo -- Correo: $usuar->email - Token: $rta");
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
        case '/vehiculo':
            switch($method)
            {
                case 'POST':
                    $headers=getallheaders();
                    $patente=$_POST['patente']?? null;
                    $marca=$_POST['marca']?? null;
                    $modelo=$_POST['modelo']?? null;
                    $precio=$_POST['precio']?? null;
                    $Token=$headers["token"]??"";
                    $payload = Token::ValidarToken($Token);
                    if($payload !=null)
                    {
                        if(isset($patente)&&strlen($patente)>0 &&strlen($marca)>0&&strlen($modelo)>0&&strlen($precio)>0)
                        {
                            $auxM=Auto::ConvertirCadena($marca);
                            $auxPA=Auto::ConvertirCadena($patente);
                            $auxMo=Auto::ConvertirCadena($modelo);
                            $auxP=Auto::ConvertirCadena($precio);
                            $auto=new Auto($auxM, $auxPA, $auxMo, $auxP);
                            $rta=$auto->Save($patente);
                        }
                    }
                    
                break;
                case 'GET':

                    $headers=getallheaders();
                    $Token=$headers["token"]??"";
                    $payload = Token::ValidarToken($Token);
                    if($path=='/ingreso')
                    {
                        if($payload !=null)
                        {
                            Archivos::MostrarListasFormatoJson("archivosGuardados/autos.json");
                        }else 
                        {
                            Respuesta::MostrarRespuestas("ERROR", " Token Invalido!!");
                        }
                    break;
                    }
                    if($patente=explode('/', $path)[2])
                    {
                        $headers=getallheaders();
                        $Token=$headers["token"]??"";
                        $payload = Token::ValidarToken($Token);
                        if($payload!=null)
                        {
                            if($auto=Auto::ExistePatente($patente))
                            {
                                $auxMsj="Correo: ".$auto->email." Patente:". $auto->patente. " Ingreso: ".$auto->date. " Salida: ".$auto->fecha_egreso. "Importe: ".$auto->importe;
                                Respuesta::MostrarRespuestas("ERROR",$auxMsj );
                            }else
                            {
                                Respuesta::MostrarRespuestas("ERROR", " No existe la patente!!");
                            }
                                
                        }else
                        {
                            Respuesta::MostrarRespuestas("ERROR", " Token Invalido!!");
                        }
                    }else
                    {
                        Respuesta::MostrarRespuestas("ERROR", " Debe agregar la extension al path!!");
                    }
                    
                break;
                default:
                Respuesta::MostrarRespuestas("ERROR", " Metodo Invalido");
                break;
            }  
        break;
        case '/patente':
            switch($method)
            {
                case 'GET':

                    if($patente=explode('/', $path)[2])
                    {
                            $headers=getallheaders();
                            $buscar= $_GET['buscar']??'';
                            $Token=$headers["token"]??"";
                            $payload = Token::ValidarToken($Token);
                            if($payload!=null)
                            {
                                if(Auto::ExistePatente($patente))
                                {
                                    $auxBuscar=Auto::ConvertirCadena($buscar);
                                    if(Auto::SiExisteVehiculo($auxBuscar)==true)
                                    {
                                        if($vehiculo=Auto::ExisteVehiculo($auxBuscar))
                                        {

                                            Respuesta::MostrarRespuestas($respuesta->estado, "Marca: $vehiculo->marca Patente: $vehiculo->patente Modelo: $vehiculo->modelo  Precio: $vehiculo->precio");
                                        }

                                    }else 
                                    {
                                        Respuesta::MostrarRespuestas("ERROR!!", "No existe $auxBuscar ");
                                    }

                                }else
                                {
                                    Respuesta::MostrarRespuestas("ERROR", " No existe la patente!!");
                                }
                                
                            }else
                            {
                                Respuesta::MostrarRespuestas("ERROR", " Token Invalido!!");
                            }
                        
                    }  
                   
                break;
                default:
                Respuesta::MostrarRespuestas("ERROR", " Metodo Invalido");
                break;
            }  
        break;  
        case '/servicio':
            switch($method)
            {
                case 'POST':

                    $headers=getallheaders();
                    $nombre=$_POST['nombre']?? null;
                    $id=$_POST['id']?? null;
                    $tipo=$_POST['tipo']?? null;
                    $precio=$_POST['precio']?? null;
                    $demora=$_POST['demora']?? null;
                    $Token=$headers["token"]??"";
                    $payload = Token::ValidarToken($Token);
                    
                    if($payload != null)
                    {
                        if(strlen($nombre)>0&& strlen($id)>0 && strlen($tipo)>0 && strlen($precio)>0 && strlen($demora)>0)
                        {
                            $servicio=new Servicio($nombre,$id,$tipo,$precio,$demora);
                            $rta=$servicio->Save($servicio);

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
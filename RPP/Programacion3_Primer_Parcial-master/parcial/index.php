<?php
require_once './cliente.php';
require_once './materia.php';
require_once './response.php';
require_once './Token.php';
require_once './profesor.php';
require_once './asignacion.php';


$method= $_SERVER["REQUEST_METHOD"];
$path=  $_SERVER["PATH_INFO"]??"ruta inexistente";

$response= new Response();
switch ($path) {

    
    case '/usuario':

        if ($method=="POST") {

            if ($method=="POST") {
            
                $email=$_POST['email'] ?? null; 
                $clave =$_POST['clave'] ?? null;
    
                if (isset($email)&&isset($clave)) {
    
                    $user = new Cliente($email,$clave);

                    if(Cliente::ValidarUserRepetido($user))
                    {
                        $response->data = "Usuario repetido";
                        $response->status = "failed";
                    }
                    else {

                         $rta=$user->Save();
                         $response->data = "Archivo guardado con exito ".$rta;
                    }

                    
        
                }
                else{
                    $response->data = "faltan datos";
                    $response->status = "failed";
    
                }
    
            }

   

        } else {
            $response->data = "Metodo no permitido";
            $response->status = "failed";
        }
        
       
        break;
    case '/login':
        
        if ($method=="POST") {

            $email=$_POST['email'] ?? null; 
            $clave= $_POST['clave'] ?? null; 

            if (isset($email)&&isset($clave)) {

                    $rta=Cliente::validarUser($email,$clave);
                    $response->data = $rta;
              
    
            }
            else{
                $response->data = "faltan datos";
                $response->status = "failed";

            }



        
        } else {
            $response->data = "Metodo no permitido";
            $response->status = "failed";
        }
        
        
         break;
         
     case '/materia':

        if ($method=="POST") {

            $headers=getallheaders();

            $nombre=$_POST['nombre'] ?? null; 
            $cuatrimestre= $_POST['cuatrimestre'] ?? null; 
  
            $Token=$headers["token"]??"";

           $payload = Token::ValidarToken($Token);

           if ($payload!=null) {
                                       
                   if (isset($nombre)&&isset($cuatrimestre)) { 
       
                           $nuevoProducto = new Materia($nombre,$cuatrimestre);

                               $rta=$nuevoProducto->Save();
                               $response->data = "Archivo guardado con exito ".$rta;
                       
                       }
       
                       else {
                           $response->data = "faltan datos";
                           $response->status = "failed";
                       }
               
             
           }
           else
           {
            $response->data = "Token invalido";
            $response->status = "failed";
           }


 
        } 
        elseif ($method=="GET") {

            $headers=getallheaders();
            $Token=$headers["token"]??"";

            $payload = Token::ValidarToken($Token);

            if ($payload!=null) {
            
                    //$lista= Datos::LeerJSON("Productos.json");
                    $lista= Datos::LeerJSON_Serializado("data/materias.json");
                    if ($lista!=false) {
        
                        $response->data =$lista;
                    } else {
                        $response->data = "Lista vacia";
                        $response->status = "failed";
                    }               
                     
            }
            else {
                $response->data = "Token invalido";
                $response->status = "failed";
            }
               
       
        } 
        
        
        else {
            $response->data = "Metodo no permitido";
            $response->status = "failed";
        }
        
        
    break;

    case '/profesor':

        if ($method=="POST") {

            $headers=getallheaders();

            $nombre= $_POST['nombre'] ?? null; 
            $legajo =$_POST['legajo'] ?? null;
            $Token=$headers["token"]??"";
            $name=$_FILES["imagen"]["name"]??null;
            $tmp_name=$_FILES["imagen"]["tmp_name"]??null;

           $payload = Token::ValidarToken($Token);

           if ( $payload!=null) {
    
                   if (isset($nombre)&&isset($legajo)&&isset($name)) {
    
                      $profesor= new Profesor($nombre,$legajo);
                       
                       if (Profesor::ValidarLegajoRepetido($profesor->legajo)==false) {

                           $profesor->imagen=Datos::GuardarFoto($name,$tmp_name,$profesor->legajo);
                            $rta=$profesor->Save();
                            $response->data = "Archivo guardado con exito ".$rta;
                           
        
                           
                       } else {
                           $response->data = "legajo repetido";
                           $response->status = "failed";
                       }
                            
                       
                   } else {
                       $response->data = "faltan datos";
                       $response->status = "failed";
                   }        

           }
           else {
            $response->data = "Token invalido";
            $response->status = "failed";
           }


        }
        elseif ($method=="GET") {

            $headers=getallheaders();
            $Token=$headers["token"]??"";

            $payload = Token::ValidarToken($Token);

            if ($payload!=null) {
            
                    //$lista= Datos::LeerJSON("Productos.json");
                    $lista= Datos::LeerJSON_Serializado("data/profesores.json");
                    if ($lista!=false) {
        
                        $response->data =$lista;
                    } else {
                        $response->data = "Lista vacia";
                        $response->status = "failed";
                    }               
                     
            }
            else {
                $response->data = "Token invalido";
                $response->status = "failed";
            }
               
       
        } 
        
        
        else {
            $response->data = "Metodo no permitido";
            $response->status = "failed";
        }
        
        
         break;

          case '/asignacion':

            if ($method=="POST") {

                $headers=getallheaders();

               $legajo= $_POST['legajo'] ?? null; 
               $id =$_POST['id'] ?? null;
               $turno =$_POST['turno'] ?? null;
               $Token=$headers["token"]??"";
                
               if (isset($legajo)&&isset($id)&&isset($turno)) {

                if ($turno=="mañana" || $turno=="noche") {

                    if (Profesor::ValidarLegajoRepetido($legajo) && Materia::ValidarMateriaRepetida($id)) {

                        $asignacion= new Asignacion($legajo,$id,$turno);
                        if (Asignacion::ValidarLegajoRepetido($asignacion)==false) {

                            $rta=$asignacion->Save();
                            $response->data = "Archivo guardado con exito ".$rta;
                           
                        }
                        else
                        {
                            $response->data = "El profesor no puede cursar la misma materia en el mismo turno";
                            $response->status = "failed";
                        }

                        
                    }
                    else {
                        $response->data = "el profesor o la materia no existen";
                        $response->status = "failed";
                    }


                }
                else {
       
                    $response->data = "tipo de asignacion incorrecta";
                    $response->status = "failed";
                    
                }

               }
               else {
                $response->data = "faltan datos";
                $response->status = "failed";
               }
    
                
            }
            elseif ($method=="GET") {

                $headers=getallheaders();
                $Token=$headers["token"]??"";
    
                $payload = Token::ValidarToken($Token);
    
                if ($payload!=null) {
                
                        //$lista= Datos::LeerJSON("Productos.json");
                        $lista= Datos::LeerJSON_Serializado("data/materias-profesores.json");
                        if ($lista!=false) {
            
                            $response->data =$lista;
                        } else {
                            $response->data = "Lista vacia";
                            $response->status = "failed";
                        }               
                         
                }
                else {
                    $response->data = "Token invalido";
                    $response->status = "failed";
                }
                   
           
            } 
              else {
              $response->data = "Metodo no permitido";
              $response->status = "failed";
            }

             break;
         
    default:
    $response->data = "Ruta inexistente";
    $response->status = "failed";
        break;
    }
    
    echo json_encode($response);
    
    
?>
<?php

namespace App\Controller;

use App\Models\Materia;
use Clases\Respuesta;
use Clases\Token;


class UserController
{
    public function GetAll($request, $response, $args) {
        //$rta=User::get();//trae todos
        //$rta=User::find(2);//trae uno
        $rta=User::where('id','>',0)->first();//o get()
        $response->getBody()->write(json_encode($rta));
        return $response;
    }
    public function GetOne($request, $response, $args) 
    {
        $ArrayDeParametros = $request->getParsedBody();

        $user=User::where('legajo', $ArrayDeParametros['legajo'])
        ->where('email',$ArrayDeParametros['email'])
        ->get();
        if($user)
        {
            $respuesta=new Respuesta();
            $payload = array("legajo" => $ArrayDeParametros['legajo']);
            $retorno = Token::CrearToken($payload);
            $rta=Respuesta::MostrarRespuestas($respuesta->estado, "Usuario:  $user Token: $retorno" );
        }

        $response->getBody()->write(json_encode($rta));
        return $response;
    }
    
    public function Add($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        $email=$ArrayDeParametros['email'];
        
        if(User::EsUsuarioExistente($email))
        {
            $response->getBody()->write(json_encode("El correo ya existe"));
        }else
        {
            $user=new User;
            $user->email=$ArrayDeParametros['email'];
            $clave=User::CodificarClave($ArrayDeParametros['clave']);
            $user->clave=$clave;
            $user->tipo=$ArrayDeParametros['tipo'];  
            $rta = $user->save();
            $response->getBody()->write(json_encode($rta));
        }
        
        return $response;
    }
    public function Update($request, $response, $args) {
        $id=$args['id'];
        $user=User::find($id);

        $user->Nombre="Ras18";
        $user->tipo="Admon";

        $rta=$user->save();
        $response->getBody()->write(json_encode($rta));
        return $response;
    }
    public function Delete($request, $response, $args) {
        $id=$args['id'];
        $user=User::find($id);

        $rta=$user->delete();
        $response->getBody()->write(json_encode($rta));
    
        return $response;
    }
}
?>
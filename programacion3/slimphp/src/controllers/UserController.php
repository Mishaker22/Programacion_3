<?php

namespace App\Controller;

use App\Models\User;

class UserController
{
    public function GetAll($request, $response, $args) {
        //$rta=User::get();//trae todos
        //$rta=User::find(2);//trae uno
        $rta=User::where('id','>',0)->first();//o get()
        $response->getBody()->write(json_encode($rta));
        return $response;
    }
    public function GetOne($request, $response, $args) {
        $id=$args['id'];
        $user=User::find($id);

        $response->getBody()->write(json_encode($user));
        return $response;
    }
    public function Add($request, $response, $args)
    {
        $user = new User;
        $user->Nombre = "Juan";
        $user->tipo = "Juan@mail.com";
        
        $rta = $user->save();

        $response->getBody()->write(json_encode($rta));
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
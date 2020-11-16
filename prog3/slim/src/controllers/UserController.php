<?php
namespace App\Controllers;

use App\Models\User;

class UserController {
    public function getAll ($request, $response, $args) {
        // $rta = User::get();
        // $rta = User::find(1);
        $rta = User::where('id', '>',  0)
        // ->where('campo', 'operador', 'valor')        
        ->get();

        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function getOne($request, $response, $args)
    {
        $response->getBody()->write("getOne!");
        return $response;
    }

    public function add($request, $response, $args)
    {
        $user = new User;
        $user->name = "Juan";
        $user->email = "Juan@mail.com";
        $user->password = "sdxdsdsds";

        $rta = $user->save();

        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function update($request, $response, $args)
    {
        $id = $args['id'];
        $user = User::find($id);

        $user->name = "Peter";
        $user->email = "nuevo@mail.com";

        $rta = $user->save();

        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function delete($request, $response, $args)
    {
        $id = $args['id'];
        $user = User::find($id);

        $rta = $user->delete();

        $response->getBody()->write(json_encode($rta));
        return $response;
    }
}
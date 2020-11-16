<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Controller\UserController;

class user extends Model
{
    public static function CodificarClave($clave)
    {
        $claveCifrada=password_hash($clave, PASSWORD_DEFAULT);
        return $claveCifrada;
    }
    public static function EsUsuarioExistente($email)
    {
        $retorno=false;
        if (User::where('email', $email)->first()) 
        {
            $retorno=true;
        }
        return $retorno;
    }
     
}
?>
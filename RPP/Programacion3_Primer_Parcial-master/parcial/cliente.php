<?php
require_once './datos.php';
require_once './Token.php';

class Cliente{

    public $email;
    public $clave;


    public function __construct($email,$clave)
    {
        $this->email = $email;
        $this->clave = $clave;
    }

    public function Save()
    {
       //$lista= Datos::GuardarJSON("Usuarios.json",$this);
       $lista= Datos::GuardarJSON_Serializado("data/users.json",$this);

        return $lista;

    }


    public static function ValidarUserRepetido($user)
    {
        //$listaJson=Datos::LeerJSON("Usuarios.json");
        $listaJson=Datos::LeerJSON_Serializado("data/users.json");
        $retorno=false;

        if ($listaJson!=false) {
            foreach ($listaJson as $value) {
            
                if ($value->email == $user->email) {
                     $retorno = true;
                     break;
                }
                  
             }
        }
    
         return $retorno;

    }

public static function validarUser($email,$clave){

    //$listaJson=Datos::LeerJSON("Usuarios.json");
    $listaJson=Datos::LeerJSON_Serializado("data/users.json");
    $retorno="usuario inexistente";

    foreach ($listaJson as $value) {
            
        if ($value->email == $email && $value->clave ==$clave) {

            $payload = array("email" => $value->email);
             $retorno = Token::CrearToken($payload);
             break;
        }
          
     }


     return $retorno;


}



}
?>
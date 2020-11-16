<?php
require_once '../ModeloParcial/manejoArchivos.php';
require_once '../ModeloParcial/token.php';
class Cliente
{
    public $email;
    public $clave;
    public $imagen;
    public $tipo;

    public function __construct($email, $clave, $imagen)
    {
        $this->email=$email;
        $this->clave=$clave;
        $this->imagen=$imagen;
    }
    //Metodo magicos
    public function __get($var)
    {
        return $this->$var;
    }
    public function __set($var, $value)
    {
        $this->$var=$value;
    }
    public function Save($correo,$contraseña,$imagen)
    {
        echo $imagen;
        $claveCif=Cliente::CodificarClave($contraseña);
        $user=new Cliente($correo,$claveCif,$imagen);
        $lista= Archivos::GuardarJson("archivosGuardados/users.json",$user);

        return $lista;

    }
    public static function CodificarClave($clave)
    {
        $claveCifrada=password_hash($clave, PASSWORD_DEFAULT);
        return $claveCifrada;

    }
    public static function ValidarUsuarioRepetido($email)
    {
        
        $listaJson=Archivos::TraerJson("archivosGuardados/users.json");
        $retorno=false;

        if ($listaJson!=false) {
            foreach ($listaJson as $value) {
            
                if ($value->email == $email) {
                     $retorno = true;
                     break;
                }
                  
             }
        }
    
         return $retorno;

    }
    public static function validarUsuario($email,$clave){

        $listaJson=Archivos::TraerJson("archivosGuardados/users.json");
        $retorno="usuario inexistente";
    
        foreach ($listaJson as $value) {
                
            if ($value->email == $email)// && $value->clave ==$clave) 
            {
                if(password_verify($clave, $value->clave))
                {
                    $payload = array("email" => $value->email);
                    $retorno = Token::CrearToken($payload);
                    break;
                }            
            }             
         }
         return $retorno;
    }
    public static function GetTipoUsuario($email)
    {
        $listaJson=Archivos::TraerJson("archivosGuardados/users.json");
        $retorno='usuario';

        if ($listaJson!=false) {
            foreach ($listaJson as $value) {
            
                if ($value->email == $email) {
                     $retorno= $value->tipo;
                    break;
                }
                  
             }
        }
    
         return $retorno;
    }
    public static function DevolverUsuario($email)
    {
        $listaJson=Archivos::TraerJson("archivosGuardados/users.json");
        $retorno="no se encontro el usuario";

        if ($listaJson!=false) {
            foreach ($listaJson as $value) {
            
                if ($value->email == $email) {
                     $retorno = $value;
                     
                     break;
                }
                  
             }
        }
    
         return $retorno;
    }
}
?>
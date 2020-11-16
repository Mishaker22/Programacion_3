<?php
require_once '../Parcial1/manejoArchivos.php';
require_once '../Parcial1/Token.php';
require_once '../Parcial1/respuestas.php';
class Registro
{
    public $email;
    public $clave;
    public $imagen;
    public $tipo;

    public function __construct($email, $clave, $imagen, $tipo)
    {
        $this->email=$email;
        $this->clave=$clave;
        $this->imagen=$imagen;
        $this->tipo=$tipo;
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
    public function Save($correo,$contraseña,$imagen,$tipo)
    {
        echo $imagen;
        $claveCif=Registro::CodificarClave($contraseña);
        $user=new Registro($correo,$claveCif,$imagen,$tipo);
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
                }else{
                    Respuesta::MostrarRespuestas("ERROR"," Contraseña Erronea");
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
    public static function ValidarTipoUsuario($tipo)
    {
        $lista=Archivos::TraerJson("archivosGuardados/users.json");
        $retorno=false;

        if ($lista!=false) {
            foreach ($lista as $value) 
            {           
                if ($value->tipo == $tipo) 
                {
                    $retorno=true;
                }
                  
             }
        }
         return $retorno;
    } 
}
?>
<?php
namespace Clases;

//require __DIR__ . '../vendor/autoload.php';

use Clases\Respuesta;
use \Firebase\JWT\JWT;

class Token
{

    public static $key = "ModeloParcial";

    public static function CrearToken($payload)
    {
        
        return JWT::encode($payload, Token::$key);
    }
    public static function getToken($id, $tipo = null)
    {

        $payload = array(
            'data' => [
                'id' => $id,
                'role' => $tipo
            ]
        );

        return JWT::encode($payload, Token::$key);
    }
    public static function ValidarToken($Token)
    {     
        try {
            return JWT::decode($Token,Token::$key, array('HS256'));//devuelve el payload

        } catch (\Throwable $th) {
            return null;
        }
    }

    
    public static function isInRole($token, $role)
    {
        try {
            $decoded = JWT::decode($token, Token::$key, array('HS256'));

            if ($decoded->data != null) {

                $currentRole = $decoded->data->role ?? '';

                if ($currentRole && !empty($currentRole)) {
                    return $currentRole == $role;;
                }
            }

            Respuesta::MostrarRespuestas("Error", "No Autorizado");
        } catch (Exception $e) {
            Respuesta::MostrarRespuestas("Error", "No Autorizado");
            die();
        }
        
    }
    public static function ValidarTokenEmail()
    {
        try {
            $token = getallheaders()['token'] ?? '';
            $decoded = JWT::decode($token, Token::$key, array('HS256'));
            return $decoded->data->id;
        } catch (Exception $e) {
            return '';
        }
    }
}

?>
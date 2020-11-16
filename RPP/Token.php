<?php
require __DIR__ . '/vendor/autoload.php';
require_once '../RPP/respuestas.php';
use \Firebase\JWT\JWT;

class Token
{

    public static $key = "primerparcial";

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

    public static function EsEncargado($payload)
    {
        try {
            if ($payload->tipo=="encargado") {
                return true;
            } else {
                return false;
            }
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
<?php
    use \Firebase\JWT\JWT;
    //composer require firebase/php-jwt
    require_once './vendor/autoload.php';
    
    

    class Auth {

        public static function login($email,$clave,$key){
            $rta = Datos::leerJSON('users.json');        
            $retorno = false;
            if($rta) {
                foreach ($rta as $cliente) {
                    if($cliente->email == $email && $cliente->clave == $clave){
                        $payload = array (
                            "email" => $cliente->email,
                            "clave" => $cliente->clave,
                        );
                        $retorno = true;
                        break;
                    }
                }
                if($retorno) {
                    $retorno = JWT::encode($payload,$key);
                }
            }
            return $retorno;
        }
        
        public static function decodeToken($header,$key)
        {
            $headers = getallheaders();
            $token = $headers[$header] ?? '';

            try {
                $decoded = JWT::decode($token, $key, array('HS256'));

                return $decoded; // se puede ver con print_r

            } catch (\Throwable $th) {
                echo $th->getMessage();
            }

        }

        public static function validarTipo($decodificado,$tipo) {
            $validado = false;
            if($tipo == $decodificado->tipo) {
                $validado = true;
            }

            return $validado;
        }

    }
?>
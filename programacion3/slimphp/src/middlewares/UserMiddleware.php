<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class UserMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        $jwt=!true;//validar el token
        if(!$jwt)
        {
            $response=new Response();
            $rta=array("rta"=>"No tiene permisos de admin");
            $response->getBody()->write(json_encode($rta));
            return $response;
        }else
        {
            $response = $handler->handle($request);
            $existingContent = (string) $response->getBody();

            $rta = new Response();
            $rta->getBody()->write($existingContent);
            return $rta;
        }
        
    }
}
?>
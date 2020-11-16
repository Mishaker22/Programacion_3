<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class TiposMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        $ArrayDeParametros = $request->getParsedBody();
        $tipo=$ArrayDeParametros['tipo'];
        if($tipo=="alumno"||$tipo=="profesor"||$tipo=="admin")
        {
            $response = $handler->handle($request);
            $existingContent = (string) $response->getBody();

            $rta = new Response();
            $rta->getBody()->write($existingContent);
            return $rta;
        }else
        {
            $response=new Response();
            $rta=array("rta"=>"Tipo incorrecto");
            $response->getBody()->write(json_encode($rta));
            return $response;
        }
        
    }
}
?>
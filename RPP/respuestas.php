<?php

class Respuesta{
    public $estado;
    public $info;


    public function __Construct()
    {
        $this->estado=" Realizado";
    }
     public static function MostrarRespuestas($estados, $infor)
     {
         $respuesta=new Respuesta();
         $respuesta->info=" $infor ";
         $respuesta->estado=" $estados ";
        echo json_encode($respuesta);
     }
}

?>
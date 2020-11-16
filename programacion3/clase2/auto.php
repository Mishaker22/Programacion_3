<?php
class Auto
{
    public $_patente;
    public $_color;
    private $_precio;
    public $_marca;
    private $_fecha;

    public function __construct($_patente,$_marca,$_color, $_precio=0, $_fecha=null)
    {
        $this->_patente=$_patente;
        $this->_marca=$_marca;
        $this->_color=$_color;
        $this->_precio=$_precio;
        $this->_fecha=$_fecha;
    }
    //metodos magicos ->
    public function __get($name)
    {
        return $this->$name;
    }
    public function __set($name, $value)
    {
        $this->$name=$value;
    }
    public function __toString()
    {
        return $this->_patente.'*'.$this->_marca.'*'.$this->_color.'*'.$this->_precio.'*';
    }// hasta aqui<--
    public function AgregarImpuestos($impuestos)
    {
        $this->_precio+=$impuestos;
    }

}
?>
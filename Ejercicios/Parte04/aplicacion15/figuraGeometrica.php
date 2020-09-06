<?php

abstract class FiguraGeometrica{

protected $_color;
protected $_perimetro;
protected $_superficie;

    public function __construct()
    {
        
    }

    public function __toString()
    {
        return 'color '.$this->_color.' perimetro '.$this->_perimetro.' superficie '.$this->_superficie.'<br>';
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public abstract function Dibujar();

    protected abstract function CalcularDatos();
}

?>
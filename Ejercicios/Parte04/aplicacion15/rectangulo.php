<?php
require_once('./figuraGeometrica.php');
class Rectangulo extends FiguraGeometrica{

    private $_base;
    private $_altura;

    public function __construct($base, $altura)
    {
        parent::__construct();
        $this->_base = $base;
        $this->_altura = $altura;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function CalcularDatos(){
         $this->_superficie = $this->_base * $this->_altura; 
         $this->_perimetro =  ($this->_base * 2) + ($this->_altura * 2); 
    }

    public function Dibujar(){

        $sbase = "";

        for($i = 0; $i < $this->_base; $i++){
            $sbase = $sbase.'*';
        }

        for($i = 0; $i < $this->_altura; $i++){
            echo $sbase.'<br>';
        }

    }

}

?>
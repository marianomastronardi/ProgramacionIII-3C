<?php
require_once('./figuraGeometrica.php');
class Triangulo extends FiguraGeometrica
{
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

    public function CalcularDatos()
    {
        $this->_superficie = ($this->_base * $this->_altura) / 2;
        $this->_perimetro =  (sqrt(pow($this->_base, 2) + pow($this->_altura, 2)) * 2) + $this->_base;
    }

    public function Dibujar()
    {
        for ($i = 1; $i <= $this->_altura; $i++) {
            $row = "";
            if ($i%2 != 0) {
                for ($j = 0; $j < $i; $j++) {
                    $row = $row."*";
                }
            }
            echo $row.'<br>';
        }
    }
}

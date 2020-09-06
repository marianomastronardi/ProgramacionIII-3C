<?php
/*
Aplicación Nº 17 (Auto)
Realizar una clase llamada “Auto” que posea los siguientes atributos privados :
_color (String)
_precio (Double)
_marca (String).
_fecha (DateTime)
Realizar un constructor capaz de poder instanciar objetos pasándole como parámetros:
i. La marca y el color.
ii. La marca, color y el precio.
iii. La marca, color, precio y fecha.
Realizar un método de instancia llamado “ AgregarImpuestos”, que recibirá un doble por
parámetro y que se sumará al precio del objeto.
Realizar un método de clase llamado “MostrarAuto”, que recibirá un objeto de tipo “Auto”
por parámetro y que mostrará todos los atributos de dicho objeto.   
Crear el método de instancia “Equals” que permita comparar dos objetos de tipo “Auto” . Sólo
devolverá TRUE si ambos “Autos” son de la misma marca.
Crear un método de clase, llamado “Add” que permita sumar dos objetos “Auto” (sólo si son
de la misma marca, y del mismo color, de lo contrario informarlo) y que retorne un Double con
la suma de los precios o cero si no se pudo realizar la operación.

*/


class Auto 
{
    private $color;
    private $precio;
    private $marca;
    private $fecha;

    //Contructor

    public function __construct($marca, $color, $precio = 0, $fecha = null){
        $this->color = $color;
        $this->marca = $marca;
        $this->precio = $precio;
        $this->fecha = $fecha;
    }

    public function AgregarImpuestos($addPrecio){
        $this->precio += $addPrecio;
        echo $this->precio;
    }

    public static function MostrarAuto($auto){
        var_dump($auto);
    }

    public function __toString()
    {
        return $this->marca.''.$this->color;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    /*
    public static function Equals($auto){
        return ($this->marca == $auto->marca);
    }

    public static function Add($autoUno, $autoDos){
        $res = "";
        if($autoUno->marca ==  $autoDos->marca && $autoUno->color ==  $autoDos->color){
            $res = $autoUno->precio +=  $autoDos->precio;
        }else{
            $res = 0;
        }
        return $res;
    }
    */
}
?>
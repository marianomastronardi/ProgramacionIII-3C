<?php
/*
 Aplicación Nº 4 (Calculadora)
Escribir un programa que use la variable $ operador que pueda almacenar los símbolos
matemáticos: ‘ + ’, ‘ - ’, ‘ / ’ y ‘ * ’; y definir dos variables enteras $ op1 y $ op2 . De acuerdo al
símbolo que tenga la variable $operador, deberá realizarse la operación indicada y mostrarse el
resultado por pantalla.
 */

$operador = array('+', '-', '*', '/');
$op1 = 9;
$op2 = 0;

foreach($operador as $key=>$value)
{
 switch ($key)
 {
     case 0:
        echo "$op1 $value $op2 = ".($op1 + $op2)."<br/>";
     break;
     case 1:
        echo "$op1 $value $op2 = ".($op1 - $op2)."<br/>";
     break;
     case 2:
        echo "$op1 $value $op2 = ".($op1 * $op2)."<br/>";
     break;
     case 3:
        if($op2 != 0)
        {
            echo "$op1 $value $op2 = ".($op1 / $op2)."<br/>";
        }
        else 
        {
            echo "No divide by zero"."<br/>";
        }
        
     break;    
 }
    
};

?>
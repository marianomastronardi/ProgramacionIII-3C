<?php

function cuadrado($numero){
    return pow($numero,2);
}

function reverseByValue($arr){
     arsort($arr);
     return $arr;
}

function isValidString($palabra, $max)
{
    $res = 0;
    $arrValidString = array('Recuperatorio', 'Parcial', 'Programacion');

    if(strlen($palabra) <= $max)
    {
        foreach($arrValidString as $value){
            if($palabra === $value){
                $res = 1;
            break;
            }
        }
    }

    return $res;
}


function esPar($num){
    return ($num%2 == 0);   
}

function esImpar($num){
    return ($num%2 != 0);   
}

?>
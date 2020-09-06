<?php
    /*
Aplicación Nº 5 (Números en letras)
Realizar un programa que en base al valor numérico de una variable $ num , pueda mostrarse
por pantalla, el nombre del número que tenga dentro escrito con palabras, para los números
entre el 20 y el 60.
Por ejemplo, si $num = 43 debe mostrarse por pantalla “cuarenta y tres”.
    */

    $num = 46;

    $array_asoc = array(
        "veinte"=>20, 
        "veintiuno"=>21, 
        "ventidos"=>22, 
        "veintitres"=>23, 
        "veinticuatro"=>24, 
        "veinticinco"=>25, 
        "veintiseis"=>26, 
        "veintisiete"=>27, 
        "veitiocho"=>28, 
        "veintinuve"=>29, 
        "treinta"=>30, 
        "treinta y uno"=>31, 
        "treinta y dos"=>32, 
        "treinta y tres"=>33, 
        "treinta y cuatro"=>34, 
        "treinta y cinco"=>35, 
        "treinta y seis"=>36, 
        "treinta y siete"=>37, 
        "treinta y ocho"=>38, 
        "treinta y nueve"=>39, 
        "cuarenta"=>40, 
        "cuarenta y uno"=>41, 
        "cuarenta y dos"=>42, 
        "cuarenta y tres"=>43, 
        "cuarenta y cuatro"=>44, 
        "cuarenta y cinco"=>45, 
        "cuarenta y seis"=>46, 
        "cuarenta y siete"=>47, 
        "cuarenta y ocho"=>48, 
        "cuarenta y nueve"=>49, 
        "cincuenta"=>50, 
        "cincuenta y uno"=>51, 
        "cincuenta y dos"=>52, 
        "cincuenta y tres"=>53, 
        "cincuenta y cuatro"=>54, 
        "cincuenta y cinco"=>55, 
        "cincuenta y seis"=>56, 
        "cincuenta y siete"=>57, 
        "cincuenta y ocho"=>58, 
        "cincuenta y nueve"=>59, 
        "sesenta"=>60 
    );

    foreach($array_asoc as $key=>$value)
    {
        if($value == $num) echo $key;
    }
?>
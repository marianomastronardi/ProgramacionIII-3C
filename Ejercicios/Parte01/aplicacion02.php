<?php
/*
Aplicación Nº 2 (Mostrar fecha y estación)
Obtenga la fecha actual del servidor (función d ate ) y luego imprímala dentro de la página con
distintos formatos (seleccione los formatos que más le guste). Además indicar que estación del
año es. Utilizar una estructura selectiva múltiple.
*/
$date = date('l jS \of F Y h:i:s A');
$mes = date('n');
$dia = date('j');
echo "$date<br/>";

switch($mes)
{
    case 1: 
        case 2:
            echo "Verano";
        break;
            case 3:
                if($dia <= 20)
                {
                    echo "Verano";
                }
                else 
                {
                    echo "Otoño";
                };
            break;
            case 4:
                case 5:
                    echo "Otoño";
                break;
                case 6:
                    if($dia <= 20)
                {
                    echo "Otoño";
                }
                else 
                {
                    echo "Invierno";
                };
            break;
            case 7:
                case 8:
                    echo "Invierno";
                break;
                case 9:
                    if($dia <= 20)
                    {
                        echo "Invierno";
                    }
                    else 
                    {
                        echo "Primavera";
                    };
                break;
                case 10:
                    case 11:
                        echo "Primavera";
                        case 12:
                            if($dia <= 20)
                            {
                                echo "Primavera";
                            }
                            else 
                            {
                                echo "Verano";
                            };     
                        break;
}
?>
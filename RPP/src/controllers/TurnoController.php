<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\Turno;
use App\Models\Vehiculo;
use App\Models\Servicio;
use DateInterval;
use DateTime;

class TurnoController
{
    public function save(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $turno = new Turno();
            $patente = $args['patente'] ?? '';
            $fecha = new DateTime($args['fecha'])?? '';
            $tipo = $args['tipo'] ?? '';

            if (strlen($patente) > 0) {
                $vehiculo = Vehiculo::find($patente);
                if (!$vehiculo) {
                    $response->getBody()->write(json_encode(array('warning' => 'La patente es incorrecta')));
                    return $response;
                } else {
                    $turno->patente = $vehiculo->patente;
                    $turno->marca = $vehiculo->marca;
                    $turno->modelo = $vehiculo->modelo;
                }
            } else {
                $response->getBody()->write(json_encode(array('warning' => 'Debe ingresar la patente')));
                return $response;
            }

            if (strlen($tipo) > 0) {
                $servicio = Servicio::find($tipo);
                if (!$servicio) {
                    $response->getBody()->write(json_encode(array('warning' => 'El servicio es incorrecto')));
                    return $response;
                } else {
                    $turno->id_tipo_servicio = $servicio->id;
                    $turno->precio = $servicio->precio;

                    //fecha segun la demora
                    $fecha = $fecha->format('Y-m-d H:i:s');
                    if (strlen($fecha) > 0) {
                        $lastShift = Turno::where('id_tipo_servicio', $tipo)->whereDate('fecha', (new DateTime($fecha)))->orderBy('fecha', 'desc')->first();
                        $fecha = new DateTime($fecha);
                        $fecha = isset($lastShift) ? (new DateTime($lastShift->fecha))->add(new DateInterval('PT'.$servicio->demora.'M')) : $fecha->add(new DateInterval('PT'.$servicio->demora.'M'));
                        $turno->fecha = $fecha;
                    } else {
                        $response->getBody()->write(json_encode(array('warning' => 'Debe ingresar la fecha')));
                        return $response;
                    }
                }
            } else {
                $response->getBody()->write(json_encode(array('warning' => 'Debe ingresar el tipo de servicio')));
                return $response;
            }
            $turno->save();
            $response->getBody()->write(json_encode(array('message' => 'Turno guardado correctamente')));
            return $response;
        } catch (\Throwable $th) {
            $response->getBody()->write($th->getMessage());
            return $response;
        }
    }

    public function getStats(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $body = $request->getParsedBody();
            $tipo = $body['tipo']??'';
            
            if(strlen($tipo)>0){
                $turno = Turno::where('id_tipo_servicio', $tipo)->get();
                $response->getBody()->write(json_encode($turno));        
            }else{
                $turno = Turno::get();
                $response->getBody()->write(json_encode($turno)); 
            }
            return $response;
        } catch (\Throwable $th) {
            $response->getBody()->write($th->getMessage());
            return $response;
        }
    }
}

<?php

namespace App\Controllers;

use App\Models\Pet;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use DI\ContainerBuilder;
use Seguridad\iToken;
use App\Models\User;
use App\Models\Shift;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Capsule\Manager as DBs;

class TurnoController
{

    public function add(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $body = $request->getParsedBody();

            if (strlen($body['fecha_turno'] ?? '') > 0) {
                $shiftDate = new DateTime($body['fecha_turno']);
                $shiftDate->format('d/m/Y H:i:s');
                //Valido la Hora
                if (intval($shiftDate->format('H')) < 9 || intval($shiftDate->format('H')) > 17) {
                    $response->getBody()->write(json_encode(array('message' => 'Shits are between 09:00 AM and 05:00 PM')));
                } else {
                    //Valido los minutos si son pasadas las 17hs
                    if (intval($shiftDate->format('H')) == 17 && intval($shiftDate->format('i')) > 0) {
                        $response->getBody()->write(json_encode(array('message' => 'Shifts are between 09:00 AM and 05:00 PM')));
                    } else {
                        //Valido la cantidad de turnos para ese dia
                        $shifts[] = new Shift();
                        $shifts = Shift::select('vet_id', 'fecha')->where('fecha', $shiftDate)->groupBy('vet_id', 'fecha')->get();

                        if (count($shifts) == 2) {
                            $response->getBody()->write(json_encode(array('message' => 'There is no shifts available for that time')));
                        } else {
                            if (count($shifts) == 1) {
                                //valido si el veterinario vino por body
                                if (strlen($body['vet_id'] ?? '') == 0) {
                                    $response->getBody()->write(json_encode(array('message' => 'vet_id is required')));
                                } else {
                                    //valido si el veterinario es el mismo
                                    if ($shifts[0]['vet_id'] == $body['vet_id']) {
                                        $response->getBody()->write(json_encode(array('message' => 'vet_id is not available for that time')));
                                    } else {
                                        //valido si la mascota vino por body
                                        if (strlen($body['mascota_id'] ?? '') == 0) {
                                            $response->getBody()->write(json_encode(array('message' => 'pet_id is required')));
                                        } else {
                                            $pet = Pet::find($body['mascota_id']);
                                            if (!isset($pet['id'])) {
                                                $response->getBody()->write(json_encode(array('message' => 'pet_id was not found')));
                                            } else {
                                                $shift = new Shift();
                                                $shift->fecha = $shiftDate;
                                                $shift->mascota_id = $body['mascota_id'];
                                                $shift->vet_id = $body['vet_id'];
                                                $shift->save();
                                                $response->getBody()->write(json_encode(array('message' => 'Shift has been saved successfuly')));
                                            }
                                        }
                                    }
                                }
                            } else {
                                //valido si la mascota vino por body
                                if (strlen($body['mascota_id'] ?? '') == 0) {
                                    $response->getBody()->write(json_encode(array('message' => 'pet_id is required')));
                                } else {
                                    $pet = Pet::find($body['mascota_id']);
                                    if (!isset($pet['id'])) {
                                        $response->getBody()->write(json_encode(array('message' => 'pet_id was not found')));
                                    } else {
                                        $shift = new Shift();
                                        $shift->fecha = $shiftDate;
                                        $shift->mascota_id = $body['mascota_id'];
                                        $shift->vet_id = $body['vet_id'];
                                        $shift->save();
                                        $response->getBody()->write(json_encode(array('message' => 'Shift has been saved successfuly')));
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $response->getBody()->write(json_encode(array('message' => 'fecha_turno is required')));
            }
            return $response;
        } catch (\Throwable $th) {
            $response->getBody()->write($th->getMessage());
            return $response;
        }
    }

    public function getByUserId(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $user = User::find($args['id_usuario']);

            //Valido si existe el user
            if (!isset($user['id'])) {
                $response->getBody()->write(json_encode(array('message' => 'User was not found')));
            } else {
                if ($user['tipo_usuario'] == 'veterinario') {
                    $q = Shift::select('pets.nombre', 'shifts.fecha', 'customers.nombre as cliente', 'pets.edad')
                        ->whereDate('fecha', date("Y-m-d"))
                        ->where('users.id', $user->id)
                        ->join('vets', 'vets.id', '=', 'shifts.id')
                        ->join('users', 'users.id', '=', 'vets.usuario_id')
                        ->join('pets', 'pets.id', '=', 'shifts.mascota_id')
                        ->join('customers', 'customers.id', '=', 'pets.cliente_id')
                        ->get();
                    $response->getBody()->write(json_encode($q));
                } elseif ($user['tipo_usuario'] == 'cliente') {
                    $q = Shift::select('pets.nombre', 'shifts.fecha', 'vets.nombre as veterinario')
                        //->whereDate('fecha', date("Y-m-d"))
                        ->where('users.id', $user->id)
                        ->join('vets', 'vets.id', '=', 'shifts.id')
                        ->join('pets', 'pets.id', '=', 'shifts.mascota_id')
                        ->join('customers', 'customers.id', '=', 'pets.cliente_id')
                        ->join('users', 'users.id', '=', 'customers.usuario_id')
                        ->get();
                    $response->getBody()->write(json_encode($q));
                } else {
                    $response->getBody()->write(json_encode(array('message' => 'User Type not allowed to get the list')));
                }
            }
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
            //print_r($e);
            /*  if($error_code == 1062){
                self::delete($lid);
                return 'houston, we have a duplicate entry problem';
            } */
            $response->getBody()->write((string)$error_code);
            return $response;
        } catch (\Throwable $th) {
            $response->getBody()->write(json_encode($th->getMessage()()));
            return $response;
        }
    }
}

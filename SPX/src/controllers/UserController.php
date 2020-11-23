<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use DI\ContainerBuilder;
use Seguridad\iToken;
use App\Models\User;


class UserController
{

    public function signup(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        //$response->getBody()->write("Hello world from POST!");
        try {
            //$directory =  __DIR__ . '/../../img';
            $body = $request->getParsedBody();
            $user = new User;
            $user->email = $body["email"];
            $user->tipo_usuario = $body["tipo_usuario"];
            $user->password = password_hash($body["password"], PASSWORD_BCRYPT);

            //foto
            //if (!is_dir($directory)) mkdir($directory);
            $uploadedFiles = $request->getUploadedFiles();
            $uploadedFile = $uploadedFiles['foto'];
            var_dump($uploadedFile);
            if($uploadedFile) $user->foto = serialize($uploadedFile);
            //if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            //    $filename = $this->moveUploadedFile($directory, $uploadedFile);
            //}
            //$user->foto = dirname(dirname(__DIR__, 1)) . '\\img\\' . $filename; //$body["foto"];
            $user->save();
            $response->getBody()->write(json_encode(array("rta" => "Usuario guardado correctamente")));
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
            /*  if($error_code == 1062){
                    self::delete($lid);
                    return 'houston, we have a duplicate entry problem';
                } */
            $response->getBody()->write((string)$error_code);
            return $response;
        } catch (\Throwable $th) {
            $response->getBody()->write($th->getMessage());
            return $response;
        }
    }

    function moveUploadedFile(string $directory, UploadedFileInterface $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

        // see http://php.net/manual/en/function.random-bytes.php
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }

    public function LogIn(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $body = $request->getParsedBody();
            $legajo = $body["legajo"] ?? '';
            if (strlen($legajo) > 0) {
                $user = User::select('legajo')->where('legajo', $legajo)->first();
                if (isset($user)) {
                    $email = $body["email"] ?? '';
                    if (strlen($email) > 0) {
                        if (!User::find($email)) {
                            $response->getBody()->write(json_encode(array('message' => "email incorrecto")));
                        } else {
                            $token = iToken::encodeUserToken($email, $legajo);
                        }
                    } else {
                        $response->getBody()->write(json_encode(array("error" => "Debe ingresar un email")));
                    }
                } else {
                    $response->getBody()->write(json_encode(array("error" => "Usuario no existe")));
                }
            } else {
                $response->getBody()->write(json_encode(array("token" => "Debe ingresar un legajo")));
                return $response;
            }

            if (isset($token)) $response->getBody()->write(json_encode($token));
            return $response;
        } catch (\Throwable $th) {
            $response->getBody()->write($th->getMessage());
            return $response;
        }
    }

    public function add(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $body = $request->getParsedBody();
            $email = $body["email"] ?? '';

            if (strlen($email) > 0) {
                $user = User::find($email);
                if (!$user) {
                    $password = $body["password"] ?? '';
                    if (strlen($password)) {
                        $password = password_hash($password, PASSWORD_BCRYPT);
                        $tipo = $body["tipo"] ?? '';
                        if (strlen($tipo) == 0) {
                            $response->getBody()->write(json_encode(array('message' => "Debe ingresar el tipo de usuario")));
                            return $response;
                        }
                    } else {
                        $response->getBody()->write(json_encode(array("error" => "Debe ingresar la contraseña")));
                        return $response;
                    }
                } else {
                    $response->getBody()->write(json_encode(array("error" => "Usuario ya existente")));
                    return $response;
                }
            } else {
                $response->getBody()->write(json_encode(array("error" => "Debe ingresar el email")));
                return $response;
            }
            $user = new User();
            $user->email = $email;
            $user->password = $password;
            $user->tipo = $tipo;

            //foto
            $uploadedFiles = $request->getUploadedFiles();
            $uploadedFile = $uploadedFiles['foto'];
            var_dump($uploadedFile);
            if($uploadedFile) $user->foto = serialize($uploadedFile);
            
            //legajo
            $find = true;
            do {
                $user->legajo = rand(100000, 999999);
                $legajo = User::where('legajo', $user->legajo);
                if (!isset($legajo->legajo))  $find = false;
            } while ($find);
            //var_dump($user);
            //die();
            $user->save();
            $response->getBody()->write(json_encode($user));
            return $response;
        } catch (\Throwable $th) {
            $response->getBody()->write(json_encode($th));
            return $response;
        }
    }

    public function setEntity(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $user = User::where('legajo', $args["legajo"]);
            if (isset($user->legajo)) {
                switch ($user->tipo) {
                    case 'admin':
                        echo 'admin';
                        break;
                    case 'alumno':
                        echo 'alumno';
                        break;
                    case 'profesor':
                        echo 'profesor';
                    default:
                        echo 'tipo no existe';
                        break;
                }
            } else {
                $response->getBody()->write(json_encode(array('message' => 'Legajo inexistente')));
            }
            $response->getBody()->write(json_encode($user));
            return $response;
        } catch (\Throwable $th) {
            $response->getBody()->write(json_encode($th));
            return $response;
        }
    }
}

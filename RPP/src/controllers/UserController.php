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
    public function getAll(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $rta = User::get();
            //$body = $request->getParsedBody();
            $response->getBody()->write(json_encode($rta));
            return $response;
        } catch (\Throwable $th) {
            var_dump($th);
            $response->getBody()->write(json_encode($th));
            return $response;
        }
    }

    public function signup(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        //$response->getBody()->write("Hello world from POST!");
        try {
            $directory =  __DIR__ . '/../../img';
            $body = $request->getParsedBody();
            $user = new User;
            $user->email = $body["email"];
            $user->tipo_usuario = $body["tipo_usuario"];
            $user->password = password_hash($body["password"], PASSWORD_BCRYPT);

            //foto
            if (!is_dir($directory)) mkdir($directory);
            $uploadedFiles = $request->getUploadedFiles();
            $uploadedFile = $uploadedFiles['foto'];
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $filename = $this->moveUploadedFile($directory, $uploadedFile);
            } 
            $user->foto = dirname(dirname(__DIR__, 1)).'\\img\\'.$filename;//$body["foto"];
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
            $user = User::find($body["email"]);
            if($user){
                if(isset($body["password"])){
                    if(!password_verify($body["password"], $user->password)){
                        $response->getBody()->write(json_encode(array('message'=> "Contraseña incorrecta")));
                    }else{
                        $token = iToken::encodeUserToken($user->email, $user->password, $user->tipo_usuario);
                    }
                }else{
                    $response->getBody()->write(json_encode(array("error" => "Falta la contraseña")));
                }
            }else{
                $response->getBody()->write(json_encode(array("error" => "Usuario no existe")));
            }
           //$response->getBody()->write(json_encode(array("token" => "Usuario logueado correctamente")));
            if(isset($token)) $response->getBody()->write(json_encode($token));
            return $response;
        } catch (\Throwable $th) {
            $response->getBody()->write($th->getMessage());
            return $response;
        }
    }
    public function getOne(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $user = User::find($args["email"]);
            $response->getBody()->write(json_encode($user));
            return $response;
        } catch (\Throwable $th) {
            $response->getBody()->write(json_encode($th));
            return $response;
        }
    }
}

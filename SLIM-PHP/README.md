composer init (para iniciar un proyecto composer)
	*********composer require xxxxxxx: este es el comando base para instalar cualquier dependencia*************
composer require firebase/php-jwt
composer install (reinstala las dependencias que estan en composer.json)

.gitignore /vendor

require __DIR__.'/vendor/autoload.php' -->> siempre cargar esta linea en el index.php!!!

composer dump-autoload -o -> cuando sumo un namespace a mi archivo composer.json, tengo que ejecutar este comando

composer require slim/slim:"4.*"
composer require slim/psr7
$app->setBasePath("/ProgramacionIII-3C/SLIM-PHP");
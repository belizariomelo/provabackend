<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use App\Utils\SimpleContainer;

// Configuração do contêiner
$container = new SimpleContainer();
AppFactory::setContainer($container);

// Criação da aplicação
$app = AppFactory::create();

// Middleware para parsing de corpo da requisição
$app->addBodyParsingMiddleware();

// Carregamento de configurações e rotas
(require __DIR__ . '/../config/settings.php')($app);
(require __DIR__ . '/../app/Routes/routes.php')($app);

// Middleware para gerenciamento de rotas
$app->addRoutingMiddleware();

// Middleware para tratamento de erros
$app->addErrorMiddleware(true, true, true); // (displayErrorDetails, logErrors, logErrorDetails)

// Executar a aplicação
$app->run();

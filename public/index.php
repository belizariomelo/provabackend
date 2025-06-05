<?php

use Slim\Factory\AppFactory;
use Slim\Middleware\BodyParsingMiddleware;
use App\Controllers\TransacaoController;
use DI\Container;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();

$container->set(PDO::class, function () {
    $pdo = new PDO('sqlite:' . __DIR__ . '/db.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS transacoes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            descricao TEXT NOT NULL,
            valor REAL NOT NULL,
            dataHora DATETIME NOT NULL
        )
    ");
    return $pdo;
});

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Carregar as rotas
(require __DIR__ . '/routes.php')($app);

// Rodar a aplicação
$app->run();

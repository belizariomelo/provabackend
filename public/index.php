<?php

require __DIR__ . '/vendor/autoload.php';

use Slim\Factory\AppFactory;
use Slim\Middleware\BodyParsingMiddleware;
use App\Controllers\TransacaoController;
use DI\Container;

// Configuração do container
$container = new Container();

$container->set(PDO::class, function () {
    $caminhoBanco = __DIR__ . '/db.sqlite';
    $pdo = new PDO('sqlite:' . $caminhoBanco);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "
        CREATE TABLE IF NOT EXISTS transacoes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            descricao TEXT NOT NULL,
            valor REAL NOT NULL,
            dataHora DATETIME NOT NULL
        )
    ";
    $pdo->exec($sql);

    return $pdo;
});

// Criação do app com o container configurado
AppFactory::setContainer($container);
$app = AppFactory::create();

// Middlewares
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, true, true);

// Inclusão das rotas
(require __DIR__ . '/routes.php')($app);

// Execução do app
$app->run();

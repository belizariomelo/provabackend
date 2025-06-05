
<?php

use Slim\App;
use App\Controllers\TransacaoController;

return function (App $app) {
    // Rota para criar transação
    $app->post('/transacao', [TransacaoController::class, 'criar']);

    // Rota para buscar uma transação por ID
    $app->get('/transacao/{id}', [TransacaoController::class, 'buscar']);

    // Rota para apagar todas as transações
    $app->delete('/transacao', [TransacaoController::class, 'apagarTudo']);

    // Rota para apagar uma transação por ID
    $app->delete('/transacao/{id}', [TransacaoController::class, 'apagar']);

    // Rota para obter as estatísticas das transações
    $app->get('/estatistica', [TransacaoController::class, 'estatisticas']);
};

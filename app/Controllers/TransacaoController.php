
<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Transacao;
use App\Services\EstatisticaService;
use PDO;
use Exception;

class TransacaoController
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Método para criar uma transação
    public function criar(Request $request, Response $response): Response
    {
        try {
            $data = $request->getParsedBody();
            $transacao = new Transacao($this->db);
            $transacao->criar($data);

            return $response->withStatus(201);
        } catch (Exception $e) {
            return $response->withStatus(500)->write($e->getMessage());
        }
    }

    // Método para buscar uma transação por ID
    public function buscar(Request $request, Response $response, array $args): Response
    {
        try {
            $id = $args['id'];
            $transacao = new Transacao($this->db);
            $resultado = $transacao->buscarPorId($id);

            if ($resultado) {
                $response->getBody()->write(json_encode($resultado));
                return $response->withHeader('Content-Type', 'application/json');
            }

            return $response->withStatus(404)->write('Transação não encontrada');
        } catch (Exception $e) {
            return $response->withStatus(500)->write($e->getMessage());
        }
    }

    // Método para apagar todas as transações
    public function apagarTudo(Request $request, Response $response): Response
    {
        try {
            $transacao = new Transacao($this->db);
            $transacao->apagarTudo();
            return $response->withStatus(200)->write('Todas as transações foram apagadas');
        } catch (Exception $e) {
            return $response->withStatus(500)->write($e->getMessage());
        }
    }

    // Método para apagar uma transação por ID
    public function apagar(Request $request, Response $response, array $args): Response
    {
        try {
            $id = $args['id'];
            $transacao = new Transacao($this->db);

            if ($transacao->apagarPorId($id)) {
                return $response->withStatus(200)->write('Transação apagada');
            }

            return $response->withStatus(404)->write('Transação não encontrada');
        } catch (Exception $e) {
            return $response->withStatus(500)->write($e->getMessage());
        }
    }

    // Método para obter as estatísticas das transações
    public function estatisticas(Request $request, Response $response): Response
    {
        try {
            $estatisticaService = new EstatisticaService($this->db);
            $resultado = $estatisticaService->calcular();
            $response->getBody()->write(json_encode($resultado));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (Exception $e) {
            return $response->withStatus(500)->write($e->getMessage());
        }
    }
}

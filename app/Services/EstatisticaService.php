
<?php

namespace App\Services;

use App\Models\Transacao;
use PDO;

class EstatisticaService
{
    private Transacao $transacaoModel;

    public function __construct(PDO $db)
    {
        $this->transacaoModel = new Transacao($db);
    }

    public function calcular(): array
    {
        // Recupera transações do último minuto
        $transacoes = $this->transacaoModel->transacoesUltimoMinuto();
        
        // Extrai os valores das transações
        $valores = array_column($transacoes, 'valor');

        // Se não houver transações, retorna valores padrão
        if (empty($valores)) {
            return [
                'sum' => 0,
                'avg' => 0,
                'min' => 0,
                'max' => 0,
                'count' => 0
            ];
        }

        // Calcula as estatísticas
        return [
            'sum' => array_sum($valores),
            'avg' => round(array_sum($valores) / count($valores), 2),
            'min' => min($valores),
            'max' => max($valores),
            'count' => count($valores)
        ];
    }
}

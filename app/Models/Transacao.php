
<?php

namespace App\Models;

use PDO;
use PDOException;

class Transacao
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Método para criar uma transação
    public function criar(array $data): void
    {
        try {
            $sql = "INSERT INTO transacoes (id, valor, dataHora) VALUES (:id, :valor, :dataHora)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id' => $data['id'],
                ':valor' => $data['valor'],
                ':dataHora' => $data['dataHora'],
            ]);
        } catch (PDOException $e) {
            throw new Exception('Erro ao criar transação: ' . $e->getMessage());
        }
    }

    // Método para buscar uma transação por ID
    public function buscarPorId(string $id): ?array
    {
        try {
            $sql = "SELECT * FROM transacoes WHERE id = :id LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            $result = $stmt->fetch();

            return $result ?: null;
        } catch (PDOException $e) {
            throw new Exception('Erro ao buscar transação: ' . $e->getMessage());
        }
    }

    // Método para apagar todas as transações
    public function apagarTudo(): void
    {
        try {
            $this->db->exec("DELETE FROM transacoes");
        } catch (PDOException $e) {
            throw new Exception('Erro ao apagar todas as transações: ' . $e->getMessage());
        }
    }

    // Método para apagar uma transação por ID
    public function apagarPorId(string $id): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM transacoes WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new Exception('Erro ao apagar transação: ' . $e->getMessage());
        }
    }

    // Método para obter transações do último minuto
    public function transacoesUltimoMinuto(): array
    {
        try {
            $sql = "SELECT valor FROM transacoes WHERE dataHora >= NOW() - INTERVAL 60 SECOND";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception('Erro ao buscar transações do último minuto: ' . $e->getMessage());
        }
    }
}

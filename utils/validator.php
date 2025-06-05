<?php

namespace App\Utils;

class Validator
{
    // Atributos para armazenar os dados
    private array $data;

    // Construtor para receber os dados
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    // Método para validar todos os campos
    public function validar(): bool
    {
        return $this->validarCamposObrigatorios() &&
               $this->validarUUID() &&
               $this->validarValor() &&
               $this->validarDataHora();
    }

    // Valida os campos obrigatórios
    private function validarCamposObrigatorios(): bool
    {
        return isset($this->data['id'], $this->data['valor'], $this->data['dataHora']);
    }

    // Valida o UUID do 'id'
    private function validarUUID(): bool
    {
        return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $this->data['id']) === 1;
    }

    // Verifica se o valor é numérico e maior ou igual a zero
    private function validarValor(): bool
    {
        return is_numeric($this->data['valor']) && $this->data['valor'] >= 0;
    }

    // Valida se a data está no formato ISO8601 e não é no futuro
    private function validarDataHora(): bool
    {
        $dataHora = strtotime($this->data['dataHora']);
        return $dataHora !== false && $dataHora <= time();
    }
}

<?php

namespace App\Utils;

use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class SimpleContainer implements ContainerInterface
{
    // Atributo para armazenar os serviços registrados
    private array $services = [];

    // Registra um serviço no contêiner
    public function add(string $serviceName, callable $serviceCallable): void
    {
        $this->services[$serviceName] = $serviceCallable;
    }

    // Resolve um serviço, retornando sua instância ou lançando exceção se não encontrado
    public function get(string $serviceName)
    {
        if (!$this->exists($serviceName)) {
            throw new ServiceNotFoundException("O serviço '$serviceName' não foi encontrado.");
        }

        // Resolve e retorna a instância do serviço
        return $this->services[$serviceName]();
    }

    // Verifica se o serviço foi registrado
    public function exists(string $serviceName): bool
    {
        return isset($this->services[$serviceName]);
    }
}

// Exceção personalizada para serviços não encontrados
class ServiceNotFoundException extends \Exception implements NotFoundExceptionInterface
{
    // Lançamento de exceção personalizada
}

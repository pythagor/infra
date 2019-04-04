<?php

namespace Infra\Resource;

use GraphQL\Type\Definition\Type;
use Infra\Infra;

class DockerEngineResource extends AbstractResource
{
    public function getAddress(): ?string
    {
        return $this->spec['address'] ?? null;
    }

    public function getPort(): ?int
    {
        return $this->spec['port'] ?? null;
    }

    public static function getConfig(Infra $infra): array
    {
        return [
            'name'   => 'DockerEngine',
            'fields' => [
                'name'        => Type::id(),
                'description' => [
                    'type'        => Type::string(),
                    'description' => 'Description',
                ],
                'address'     => [
                    'type'        => Type::string(),
                    'description' => 'Docker Engine IP address',
                ],
                'port'        => [
                    'type'        => Type::int(),
                    'description' => 'Docker Engine Port',
                ],
            ],
        ];
    }
}

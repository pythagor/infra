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

    public function getApps(): array
    {
        /** @var DockerAppResource[] $apps */
        $apps = $this->infra->getResourcesByType('DockerApp');

        $res = [];
        foreach ($apps as $app) {
            if ($app->hasDockerEngineName($this->getName())) {
                $res[] = $app;
            }
        }

        return $res;
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
                'apps'        => [
                    'type'        => Type::listOf($infra->getType('DockerApp')),
                    'description' => 'Docker Apps',
                ],
            ],
        ];
    }
}

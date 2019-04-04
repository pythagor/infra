<?php

namespace Infra\Resource;

use GraphQL\Type\Definition\Type;
use Infra\Infra;

class DockerAppResource extends AbstractResource
{
    public function getEngine()
    {
        $engineName = $this->spec['engine'];

        return $this->infra->getResource(
            $this->infra->getTypeName(DockerEngineResource::class),
            $engineName
        );
    }

    public function getAppConfig()
    {
        return json_encode($this->spec['config']) ?? null;
    }

    public static function getConfig(Infra $infra): array
    {
        return [
            'name'   => $infra->getTypeName(self::class),
            'fields' => [
                'name'        => Type::id(),
                'description' => [
                    'type'        => Type::string(),
                    'description' => 'Description',
                ],
                'engine'      => [
                    'type'        => $infra->getType($infra->getTypeName(DockerEngineResource::class)),
                    'description' => 'Docker Engine',
                ],
                'appConfig' => [
                    'type' => Type::string(),
                    'description' => 'Docker App Config'
                ]
            ],
        ];
    }
}

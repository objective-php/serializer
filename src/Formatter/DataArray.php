<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 14/06/2016
 * Time: 10:10
 */

namespace Serializer\Formatter;


use Serializer\Normalizer\Resource\Resource;

class DataArray implements FormatterInterface
{

    /**
     * @param Serializer\Normalizer\Resource\Resource $resource
     *
     * @return array
     */
    public function format(Resource $resource) : array
    {
        $dataArray = [
            'resource_id' => $resource->getId(),

            $resource->getName() => [
                'data' => $resource->getProperties(),
            ],
        ];

        if (!empty($resource->getRelations())) {
            $dataArray += ['relations' => $this->getRelations($resource)];
        }

        return $dataArray;
    }

    private function getRelations(Resource $resource)
    {
        $formattedRelations = [];
        foreach ($resource->getRelations() as $relation => $properties) {
            $formattedRelations[] = [$relation => ['data' => $properties]];
        }

        return $formattedRelations;
    }
}
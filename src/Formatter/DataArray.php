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

    public function format(Resource $resource) : array
    {
        $formattedRelations = [];
        foreach ($resource->getRelations() as $relation => $properties) {
            $formattedRelations[] = [$relation => ['data' => $properties]];
        }

        return [
           $resource->getName() => [
               'data' => $resource->getProperties()
           ],
           'relations' => $formattedRelations,
           'resource_id' => $resource->getId()
        ];
    }
}
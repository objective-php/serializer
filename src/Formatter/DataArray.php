<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 14/06/2016
 * Time: 10:10
 */

namespace Serializer\Formatter;


use Serializer\Normalizer\Resource\Resource;

/**
 * Class DataArray
 * @package Serializer\Formatter
 */
class DataArray extends AbstractFormatter
{

    /**
     * @param \Serializer\Normalizer\Resource\Resource $resource
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

    /**
     * Extract the relations of the resource to make an formatted array.
     *
     * @param \Serializer\Normalizer\Resource\Resource $resource
     *
     * @return array
     */
    protected function getRelations(Resource $resource)
    {
        $formattedRelations = [];
        /** @var \Serializer\Normalizer\Resource\Resource $subResource */
        foreach ($resource->getRelations() as $subResource) {
            $formattedRelations[] = [$subResource->getName() => ['data' => $subResource->getProperties()]];
        }

        return $formattedRelations;
    }
}
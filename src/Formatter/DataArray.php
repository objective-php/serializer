<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 14/06/2016
 * Time: 10:10
 */

namespace Serializer\Formatter;


use Serializer\Normalizer\Resource\Resource;
use Serializer\Normalizer\Resource\ResourceInterface;

/**
 * Class DataArray
 * @package Serializer\Formatter
 */
class DataArray extends AbstractFormatter
{

    /**
     * @param Resource $resource
     *
     * @return array
     */
    public function format(ResourceInterface $resource) : array
    {
        if($resource instanceof Resource) {
            $dataArray = [
                'resource_id' => $resource->getId(),

                $resource->getName() => [
                    'data' => $resource->getProperties(),
                ],
            ];

            if (!empty($resource->getRelations())) {
                $dataArray += ['relations' => $this->getRelations($resource)];
            }
        }else{
            $dataArray = [];
            /** @var  \Serializer\Normalizer\Resource\Resource $subresource */
            foreach ($resource as $subresource) {
                $data = [
                    'resource_id' => $subresource->getId(),

                    $subresource->getName() => [
                        'data' => $subresource->getProperties(),
                    ],
                ];

                if (!empty($subresource->getRelations())) {
                    $data += ['relations' => $this->getRelations($subresource)];
                }

                $dataArray[] = $data;
            }
        }





        return $dataArray;
    }

    /**
     * Extract the relations of the resource to make an formatted array.
     *
     * @param Resource $resource
     *
     * @return array
     */
    protected function getRelations(Resource $resource)
    {
        $formattedRelations = [];
        /** @var Resource $subResource */
        foreach ($resource->getRelations() as $subResource) {
            $formattedRelations[] = [$subResource->getName() => ['data' => $subResource->getProperties()]];
        }

        return $formattedRelations;
    }
}
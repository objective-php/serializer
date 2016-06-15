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
        return [
           $resource->getName() => [
               'data' => $resource->getProperties()
           ],
           'resource_id' => $resource->getId()
        ];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:33
 */

namespace Serializer\Formatter;

use Serializer\Normalizer\Resource\Resource;
use Serializer\Normalizer\Resource\ResourceSet;

/**
 * Class JsonApi
 * @package Serializer\Formatter
 */
class JsonApi extends AbstractFormatter
{

    /**
     * @param \Serializer\Normalizer\Resource\Resource $resource
     *
     * @return array
     */
    public function format(Resource $resource) : array
    {
        $links = $this->formatLinks($resource);
        $data = $this->formatData($resource);
        $included = $this->formatIncluded($resource);

        return $links + $data + $included;
    }

    /**
     * @param \Serializer\Normalizer\Resource\Resource $resource
     *
     * @return array
     */
    protected function formatLinks(Resource $resource) : array
    {
        $links = ["links" => ["self" => $resource->getBaseUri() . $resource->getName()]];
        if ($this->hasPaginer()) {
            $links['links'] += [
                "first" => $resource->getBaseUri() . $resource->getName() . '?page=1',
                "last"  => $resource->getBaseUri() . $resource->getName() . '?page=' . ($this->getPaginer()->getLastPage()),
            ];
            if ($this->getPaginer()->getCurrentPage() > 1) {
                $links['links'] +=
                    [
                        "next" => $resource->getBaseUri() . $resource->getName() . '?page=' . ($this->getPaginer()->getCurrentPage() + 1),
                        "prev" => $resource->getBaseUri() . $resource->getName() . '?page=' . ($this->getPaginer()->getCurrentPage() - 1),
                    ];
            }
        }

        return $links;
    }

    /**
     * @param \Serializer\Normalizer\Resource\Resource      $resource
     * @param \Serializer\Normalizer\Resource\Resource|null $parentResource
     *
     * @return array
     */
    protected function formatData(Resource $resource, Resource $parentResource = null)
    {

        $propertiesWithoutId = $resource->getProperties();
        unset($propertiesWithoutId['id']);

        if (!empty($parentResource)) {
            $link = $parentResource->getBaseUri() . $parentResource->getName() . '/' . $parentResource->getProperties()['id'] . '/' . $resource->getName();
        } else {
            $link = $resource->getBaseUri() . $resource->getName() . '/' . $resource->getProperties()['id'];
        }

        $data = [
            "data" => [
                "type"       => $resource->getName(),
                "id"         => $resource->getProperties()['id'],
                "attributes" => $propertiesWithoutId,
            ],
        ];

        if (!empty($resource->getRelations()) && !empty($resource->getRelations()->getResources())) {
            $data['data'] += ["relationships" => $this->formattedRelations($resource->getRelations(), $resource)];
        }

        $data['data'] += ["links" => ["self" => $link]];


        return $data;
    }

    /**
     * @param ResourceSet                              $resourceSet
     * @param \Serializer\Normalizer\Resource\Resource $parentResource
     *
     * @return array
     */
    protected function formattedRelations(ResourceSet $resourceSet, Resource $parentResource)
    {
        $relations = [];
        /** @var \Serializer\Normalizer\Resource\Resource $resource */
        foreach ($resourceSet as $resource) {
            $relations[$resource->getName()] = [
                "links" => [
                    "self"    => $parentResource->getBaseUri() . $parentResource->getName() . '/' . $parentResource->getProperties()['id'] . '/relationships/' . $resource->getName(),
                    "related" => $parentResource->getBaseUri() . $parentResource->getName() . '/' . $parentResource->getProperties()['id'] . '/' . $resource->getName(),
                ],
                "data"  => [
                    "type" => $resource->getName(),
                    "id"   => $resource->getProperties()['id'],
                ],
            ];
        }

        return $relations;
    }

    /**
     * @param \Serializer\Normalizer\Resource\Resource $resource
     *
     * @return array
     */
    protected function formatIncluded(Resource $resource) : array
    {
        $included = [];
        if (!empty($resource->getRelations())) {
            $included = [
                "included" =>
                    $this->formattedIncludedRelations($resource->getRelations(), $resource),
            ];
        }

        return $included;
    }

    /**
     * @param ResourceSet                              $resourceSet
     * @param \Serializer\Normalizer\Resource\Resource $parentResource
     */
    protected function formattedIncludedRelations(ResourceSet $resourceSet, Resource $parentResource)
    {
        $includedRelations = [];

        /** @var \Serializer\Normalizer\Resource\Resource $resource */
        foreach ($resourceSet as $resource) {
            $includedRelations[] = $this->formatData($resource, $parentResource);
        }

        return $includedRelations;
    }

}
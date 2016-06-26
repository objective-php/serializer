<?php

    namespace ObjectivePHP\Serializer\Formatter;

    use ObjectivePHP\Serializer\Resource\ResourceSet;
    use ObjectivePHP\Serializer\Resource\Resource;
    use ObjectivePHP\Serializer\Resource\ResourceInterface;
    use ObjectivePHP\Serializer\Resource\SerializableResourceInterface;

    /**
     * Class JsonApi
     *
     * @package ObjectivePHP\Serializer\Formatter
     */
    class JsonApi extends AbstractFormatter
    {

        /**
         * @param SerializableResourceInterface $resource
         *
         * @return array
         */
        public function format(SerializableResourceInterface $resource) : array
        {
            $links = $this->formatLinks($resource);

            if ($resource instanceof ResourceSet)
            {
                foreach ($resource->getResources() as $subResource)
                {
                    $data['data'][] = $this->formatData($subResource);
                }
            }
            else
            {
                $data['data'] = $this->formatData($resource);
            }

            $included = $this->formatIncluded($resource);

            return $links + $data + $included;
        }

        /**
         * @param ResourceInterface $resource
         *
         * @return array
         */
        protected function formatLinks(ResourceInterface $resource) : array
        {
            $links = ["links" => ["self" => $resource->getBaseUri() . $resource->getName()]];
            if ($this->hasPaginator())
            {
                $links['links'] += [
                    "first" => $resource->getBaseUri() . $resource->getName() . '?page=1',
                    "last"  => $resource->getBaseUri() . $resource->getName() . '?page=' . ($this->getPaginator()
                                                                                                 ->getLastPage()),
                ];


                if ($this->getPaginator()->getCurrentPage() < $this->getPaginator()->getLastPage())
                {
                    $links['links']['next'] = $resource->getBaseUri() . $resource->getName() . '?page=' . ($this->getPaginator()
                                                                                                                ->getCurrentPage() + 1);
                }
                if ($this->getPaginator()->getCurrentPage() > 1)
                {
                    $links['links']['prev'] = $resource->getBaseUri() . $resource->getName() . '?page=' . ($this->getPaginator()
                                                                                                                ->getCurrentPage() - 1);
                }
            }

            return $links;
        }

        /**
         * @param Resource      $resource
         * @param null|Resource $parentResource
         *
         * @return array
         */
        protected function formatData(Resource $resource, Resource $parentResource = null)
        {
            $data = [];

            if (!empty($parentResource))
            {
                $link = $parentResource->getBaseUri() . $parentResource->getName() . '/' . $parentResource->getProperties()['id'] . '/' . $resource->getName();
            }
            else
            {
                $link = $resource->getBaseUri() . $resource->getName() . '/' . $resource->getProperties()['id'];
            }


            $propertiesWithoutId = $resource->getProperties();
            unset($propertiesWithoutId['id']);

            $data += [
                "type"       => $resource->getName(),
                "id"         => $resource->getProperties()['id'],
                "attributes" => $propertiesWithoutId,
            ];

            if (!empty($resource->getRelations()) && !empty($resource->getRelations()->getResources()))
            {
                $data += ["relationships" => $this->formatRelations($resource->getRelations(), $resource)];
            }

            $data += ["links" => ["self" => $link]];


            return $data;
        }

        /**
         * @param ResourceSet $resourceSet
         *
         * @param Resource    $parentResource
         *
         * @return array
         */
        protected function formatRelations(ResourceSet $resourceSet, Resource $parentResource)
        {
            $relations = [];
            /** @var Resource $resource */
            foreach ($resourceSet as $resource)
            {
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
         * @param Resource $resource
         *
         * @return array
         */
        protected function formatIncluded(Resource $resource) : array
        {
            $included = [];
            if (!empty($resource->getRelations()))
            {
                $included = [
                    "included" =>
                        $this->formatIncludedRelations($resource->getRelations(), $resource),
                ];
            }

            return $included;
        }

        /**
         * @param ResourceSet $resourceSet
         * @param Resource    $parentResource
         *
         * @return array
         */
        protected function formatIncludedRelations(ResourceSet $resourceSet, Resource $parentResource)
        {
            $includedRelations = [];

            /** @var Resource $resource */
            foreach ($resourceSet as $resource)
            {
                $includedRelations[] = $this->formatData($resource, $parentResource);
            }

            return $includedRelations;
        }

    }

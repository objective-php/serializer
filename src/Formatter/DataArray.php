<?php

    namespace ObjectivePHP\Serializer\Formatter;


    use ObjectivePHP\Serializer\Resource\Resource;
    use ObjectivePHP\Serializer\Resource\ResourceInterface;
    use ObjectivePHP\Serializer\Resource\ResourceSet;
    use ObjectivePHP\Serializer\Resource\SerializableResourceInterface;

    /**
     * Class DataArray
     *
     * @package ObjectivePHP\Serializer\Formatter
     */
    class DataArray extends AbstractFormatter
    {

        /**
         *
         * @param SerializableResourceInterface $resource
         *
         * @return array
         */
        public function format(SerializableResourceInterface $resource) : array
        {

            if ($resource instanceof Resource)
            {
                $dataArray = [

                    $resource->getName() => [
                        'data' => $resource->getProperties(),
                    ],
                ];

                if (!empty($resource->getRelations()))
                {
                    $dataArray[$resource->getName()] += ['relations' => $this->getRelations($resource)];
                }

                $result['data'] = $dataArray;
            }
            else
            {
                $result = [];
                $dataArray = [];

                /** @var Resource $subResource */
                foreach ($resource as $subResource)
                {
                    $data = [

                        $subResource->getName() => [
                            'data' => $subResource->getProperties(),
                        ],
                    ];

                    if (!empty($subResource->getRelations()))
                    {
                        $data[$subResource->getName()] += ['relations' => $this->getRelations($subResource)];
                    }

                    $dataArray[] = $data;
                }
                $result['data'] = $dataArray;

                if($this->hasPaginator()){
                    $meta = [
                            'total'    => $this->getPaginator()->getTotal(),
                            'count'    => $this->getPaginator()->getCount(),
                            'per_page' => $this->getPaginator()->getPerPage(),
                            'last'     => $this->getPaginator()->getLastPage(),
                    ];

                    $result['meta'] = $meta;
                }
            }

            return $result;
        }

        /**
         * Extract the relations of the resource to make a formatted array.
         *
         * @param ResourceInterface $resource
         *
         * @return array
         */
        protected function getRelations(ResourceInterface $resource)
        {
            $formattedRelations = [];
            /** @var Resource $subResource */
            foreach ($resource->getRelations() as $subResource)
            {
                $formattedRelations[] = [$subResource->getName() => ['data' => $subResource->getProperties()]];
            }

            return $formattedRelations;
        }
    }

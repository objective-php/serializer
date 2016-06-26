<?php

    namespace ObjectivePHP\Serializer\Formatter;


    use ObjectivePHP\Serializer\Resource\Resource;
    use ObjectivePHP\Serializer\Resource\ResourceInterface;
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
            $dataArray = [];

            if ($resource instanceof ResourceInterface)
            {
                $dataArray = [
                    'resource_id' => $resource->getId(),

                    $resource->getName() => [
                        'data' => $resource->getProperties(),
                    ],
                ];

                if (!empty($resource->getRelations()))
                {
                    $dataArray += ['relations' => $this->getRelations($resource)];
                }
            }
            else
            {
                $dataArray = [];

                /** @var Resource $subResource */
                foreach ($resource as $subResource)
                {
                    $data = [
                        'resource_id' => $subResource->getId(),

                        $subResource->getName() => [
                            'data' => $subResource->getProperties(),
                        ],
                    ];

                    if (!empty($subResource->getRelations()))
                    {
                        $data += ['relations' => $this->getRelations($subResource)];
                    }

                    $dataArray[] = $data;
                }
            }

            return $dataArray;
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

<?php

    namespace ObjectivePHP\Serializer\Normalizer;


    use Doctrine\ORM\EntityManager;
    use Doctrine\ORM\Mapping\ClassMetadata;
    use ObjectivePHP\Serializer\Resource\ResourceSet;
    use ObjectivePHP\Serializer\Resource\Resource;
    use ObjectivePHP\Serializer\Resource\ResourceInterface;
    use ObjectivePHP\Serializer\Resource\SerializableResourceInterface;
    use Throwable;

    /**
     * The doctrine normalizer extract from a doctrine entity all valuable information
     * to do a simple resource.
     *
     * Class DoctrineNormalizer
     *
     * @package ObjectivePHP\Serializer\Normalizer
     */
    class DoctrineNormalizer implements NormalizerInterface
    {
        /** @var EntityManager */
        protected $entityManager;

        /** @var string */
        protected $baseUri;

        /**
         * DoctrineNormalizer constructor.
         *
         * @param string $baseUri
         *
         */
        public function __construct(string $baseUri = '')
        {
            $this->baseUri = $baseUri;
        }

        /**
         *
         * @param $data
         *
         * @return SerializableResourceInterface
         * @throws Exception
         */
        public function normalize($data) : SerializableResourceInterface
        {
            if (!$this->entityManager instanceof EntityManager)
            {
                throw new Exception('An Entity Manager is needed for normalizing doctrine entities.');
            }

            // If we want to normalize an array of entity, we have to create a ResourceSet
            if($data)
            {
                if (is_array($data) || $data  instanceof \Traversable)
                {
                    $resource = new ResourceSet();
                    $metaData = $this->entityManager->getClassMetadata(get_class($data[0]));

                    foreach ($data as $entity)
                    {
                        $resource->addChild($this->createResource($metaData, $entity));
                    }

                }
                else
                {
                    $metaData = $this->entityManager->getClassMetadata(get_class($data));
                    $resource = $this->createResource($metaData, $data);

                }
            }
            else {
                $resource = new ResourceSet;
            }

            return $resource;
        }

        /**
         * @param ClassMetadata $metaData
         * @param               $entity
         *
         * @return ResourceInterface|Resource
         * @throws Exception
         */
        protected function createResource(ClassMetadata $metaData, $entity) : Resource
        {
            $resource = new Resource();

            if (!empty($this->getBaseUri()))
            {
                $resource->setBaseUri($this->getBaseUri() . strtolower($resource->getName()) . '/');
            }
            $resource->setClass(get_class($entity));
            $resource->setName(strtolower(str_replace($metaData->namespace . '\\', '', $metaData->name)));
            $resource->setProperties($this->getEntityColumnValues($entity, $metaData));
            $resource->setRelations($this->getEmbeddedRelations($entity, $metaData));

            return $resource;
        }

        /**
         * @return string
         */
        public function getBaseUri()
        {
            return $this->baseUri;
        }

        /**
         * @param string $baseUri
         *
         * @return DoctrineNormalizer
         */
        public function setBaseUri($baseUri)
        {
            $this->baseUri = $baseUri;

            return $this;
        }

        /**
         * @param               $entity
         * @param ClassMetadata $metadata
         *
         * @return array
         * @throws Exception
         */
        protected function getEntityColumnValues($entity, ClassMetadata $metadata)
        {
            $fields = $metadata->getFieldNames();
            $values = [];

            foreach ($fields as $field)
            {
                $getter = 'get' . ucfirst($field);

                // If the method corresponding to the property does not exist in the
                // entity, we're gonna throw a simple Exception.
                try
                {
                    $values[$field] = $entity->$getter();
                }
                catch (Throwable $e)
                {
                    throw new Exception(sprintf('The method %s does not exist.', $getter));
                }
            }

            return $values;
        }

        /**
         * @param               $entity
         * @param ClassMetadata $metadata
         *
         * @return ResourceSet
         * @throws Exception
         */
        public function getEmbeddedRelations($entity, ClassMetadata $metadata)
        {
            $relations      = new ResourceSet();
            $relationsMeta  = $metadata->getAssociationMappings();
            $relationsClass = [];

            foreach ($relationsMeta as $relationMeta)
            {
                $getter = 'get' . ucfirst($relationMeta['fieldName']);

                // We're getting the embedded classes
                try
                {
                    $relationsClass[$relationMeta['fieldName']] = $entity->$getter();
                }
                catch (Throwable $e)
                {
                    throw new Exception(sprintf('The method %s does not exist.', $getter));
                }
            }

            foreach ($relationsClass as $relationClass)
            {
                $relationMetaData = $this->entityManager->getClassMetadata(get_class($relationClass));
                $relations->addChild($this->createResource($relationMetaData, $relationClass));
            }

            return $relations;
        }

        /**
         * @return EntityManager
         */
        public function getEntityManager()
        {
            return $this->entityManager;
        }

        /**
         * @param EntityManager $entityManager
         *
         * @return DoctrineNormalizer
         */
        public function setEntityManager($entityManager)
        {
            $this->entityManager = $entityManager;

            return $this;
        }
    }

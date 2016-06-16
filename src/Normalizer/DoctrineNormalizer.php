<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 14:38
 */

namespace Serializer\Normalizer;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\Tools\Setup;
use Serializer\examples\Artist;
use Serializer\Normalizer\Resource\Resource;
use Serializer\Normalizer\Resource\ResourceInterface;
use Serializer\Normalizer\Resource\ResourceSet;

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
     * @throws \Doctrine\ORM\ORMException
     */
    public function __construct(string $baseUri = null)
    {
        $this->baseUri = $baseUri;
    }

    /**
     *
     * @param $data
     *
     * @return ResourceInterface
     * @throws \Exception
     */
    public function normalize($data) : ResourceInterface
    {
        if (!$this->entityManager instanceof EntityManager) {
            throw new \Exception('An Entity Manager is needed for normalizing doctrine entities.');
        }

        if (is_array($data)) {
            $resource = new ResourceSet();
            $metaData = $this->entityManager->getClassMetadata(get_class($data[0]));

            foreach ($data as $entity) {
                $resource->addChild($this->createResource($metaData, $entity));
            }
        } else {
            $metaData = $this->entityManager->getClassMetadata(get_class($data));
            $resource = $this->createResource($metaData, $data);

        }

        return $resource;
    }

    protected function createResource(ClassMetadata $metaData, $entity) : Resource
    {
        $resource = new Resource();

        $resource->setClass(get_class($entity));
        $resource->setName(strtolower(str_replace($metaData->namespace . '\\', '', $metaData->name)));
        $resource->setBaseUri($this->baseUri . strtolower($resource->getName()));
        $resource->setProperties($this->getEntityColumnValues($entity, $metaData));
        $resource->setRelations($this->getEmbededRelations($entity, $metaData));

        return $resource;
    }

    protected function getEntityColumnValues($entity, ClassMetadata $metadata)
    {
        $fields = $metadata->getFieldNames();
        $values = [];
        foreach ($fields as $field) {
            $getter = 'get' . ucfirst($field);

            try {
                $values[$field] = $entity->$getter();
            } catch (\Error $e) {
                throw new \Exception(sprintf('The method %s does not exist.', $getter));
            }
        }

        return $values;
    }

    public function getEmbededRelations($entity, ClassMetadata $metadata)
    {
        $relations = $metadata->getAssociationMappings();
        $values = [];
        $properties = [];
        foreach ($relations as $relation) {
            $getter = 'get' . ucfirst($relation['fieldName']);

            // We're getting the embedded classes
            try {
                $values[$relation['fieldName']] = $entity->$getter();
            } catch (\Error $e) {
                throw new \Exception(sprintf('The method %s does not exist.', $getter));
            }

            // Now we're gettings their properties
            foreach ($values as $value) {
                $tempMeta = $this->entityManager->getClassMetadata(get_class($value));
                $properties[$relation['fieldName']] = $this->getEntityColumnValues($value, $tempMeta);
            }

        }

        return $properties;

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
}
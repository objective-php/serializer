<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 14:38
 */

namespace Serializer\Normalizer;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\Tools\Setup;
use Serializer\Normalizer\Resource\Resource;
use Serializer\Normalizer\Resource\ResourceInterface;
use Serializer\Normalizer\Resource\ResourceSet;

class DoctrineNormalizer implements NormalizerInterface
{
    /** @var EntityManager  */
    protected $entityManager;

    /** @var string */
    private $baseUri;

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
        if(!$this->entityManager instanceof EntityManager) throw new \Exception('An Entity Manager is needed for normalizing doctrine entities.');

        if(is_array($data)){
            $resource = new ResourceSet();
            $metaData = $this->entityManager->getClassMetadata(get_class($data[0]));

            foreach ($data as $entity) {
                $resource->addChild($this->createResource($metaData, $entity));
            }
        }else{
            $metaData = $this->entityManager->getClassMetadata(get_class($data));
            $resource = $this->createResource($metaData, $data);

        }
        return $resource;
    }

    protected function getEntityColumnValues($entity){
        $cols = $this->entityManager->getClassMetadata(get_class($entity))->getFieldNames();
        $values = array();
        foreach($cols as $col){
            $getter = 'get'.ucfirst($col);

            try{
                $values[$col] = $entity->$getter();
            }catch (\Error $e){
                throw new \Exception(sprintf('The method %s does not exist.', $getter));
            }
        }
        return $values;
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
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    protected function createResource($metaData, $entity) : Resource
    {
        $resource = new Resource();

        $resource->setClass(get_class($entity));
        $resource->setName(str_replace($metaData->namespace.'\\', '', $metaData->name));
        $resource->setBaseUri($this->baseUri . strtolower($resource->getName()));
        $resource->setProperties($this->getEntityColumnValues($entity));

        return $resource;
    }
}
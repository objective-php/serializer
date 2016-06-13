<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 14:38
 */

namespace Serializer\Normalizer;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\Tools\Setup;

class DoctrineNormalizer implements NormalizerInterface
{
    protected $entityManager;

    /**
     * DoctrineNormalizer constructor.
     */
    public function __construct()
    {
        $emConfig = Setup::createAnnotationMetadataConfiguration((array) '/', true, null, null, false);
        $emConfig->setNamingStrategy(new UnderscoreNamingStrategy());

        $this->entityManager = EntityManager::create(null, $emConfig);
    }


    /**
     * TODO: WIP
     * @param $className
     *
     * @return NormalizedObject
     */
    public function normalize($className) : NormalizedObject
    {
        $metaData = $this->entityManager->getClassMetadata($className);

        return new NormalizedObject();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:09
 */

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\Tools\Setup;
use Serializer\Encoder\JsonEncoder;
use Serializer\Serializer;

require __DIR__ . '../../vendor/autoload.php';


///////////////// entity manager === can be injected /////////////////

// the connection configuration
$dbParams = [
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => 'root',
    'dbname'   => 'Chinook',
];

$config = Setup::createAnnotationMetadataConfiguration(['/'], true, null, null, false);
$config->setNamingStrategy(new UnderscoreNamingStrategy());
$entityManager = EntityManager::create($dbParams, $config);
////////////////////////////////////////////////////////////////////


/////////////////////////// get data /////////////////////////////////
//$album = $entityManager->getRepository(\Serializer\examples\Album::class)->findBy(['id' => [1,2, 3, 4]]);
$album = $entityManager->getRepository(\Serializer\examples\Album::class)->find(1);
////////////////////////////////////////////////////////////////////

//////////////////// initialize serializer////////////////////////////////
$serializer = (new Serializer())
    ->setEncoder(new JsonEncoder())
    ->setNormalizer((new \Serializer\Normalizer\DoctrineNormalizer())->setEntityManager($entityManager))
    ->setFormatter(new \Serializer\Formatter\JsonApi());
////////////////////////////////////////////////////////////////////

////////////////////////  serialize  ///////////////////////////////////
$dataSerialized = $serializer->serialize($album);
////////////////////////////////////////////////////////////////////

echo($dataSerialized);
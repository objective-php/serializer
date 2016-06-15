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
use Serializer\Normalizer\Resource\Resource;
use Serializer\Serializer;

require __DIR__ . '../../vendor/autoload.php';


$data = [
    'resource test',
    'test'  => 'toto',
    'items' => [
        'id' => 12,
        'jambon' => false,
        'cheese' => true,
    ],
];

class CustomFormatter implements \Serializer\Formatter\FormatterInterface
{

    public function format(Resource $resource) : array
    {
        echo __METHOD__ . PHP_EOL;

        return [
            $resource->getName() => $resource->getProperties(),
        ];
    }
}

class CustomNormalizer implements \Serializer\Normalizer\NormalizerInterface
{

    public function normalize($data) : \Serializer\Normalizer\Resource\ResourceInterface
    {
        echo __METHOD__ . PHP_EOL;

        $resource = new Resource();
        $resource->setName($data[0]);
        $resource->setProperties($data['items']);

        return $resource;
    }
}
//////////// entity manager ////////////
$paths = array("/");

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => 'root',
    'dbname'   => 'Chinook',
);

$config = Setup::createAnnotationMetadataConfiguration($paths, true, null, null, false);
$config->setNamingStrategy(new UnderscoreNamingStrategy());
$entityManager = EntityManager::create($dbParams, $config);
/////////////////////////////////////

$album = $entityManager->getRepository(\Serializer\examples\Artist::class)->findBy(['id' => [1,2]]);

$serializer = (new Serializer())
    ->setEncoder(new JsonEncoder())
    ->setNormalizer((new \Serializer\Normalizer\DoctrineNormalizer())->setEntityManager($entityManager))
    //->setNormalizer(new CustomNormalizer())
    ->setFormatter(new CustomFormatter())
;

$dataSerialized = $serializer->serialize($album);
//$dataSerialized = $serializer->serialize($data);

var_dump($dataSerialized);
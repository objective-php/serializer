<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:09
 */

use Serializer\Normalizer\DoctrineNormalizer;
use Serializer\Normalizer\Resource\Resource;
use Serializer\Serializer;
use Serializer\Serializer\JsonSerializer;

require __DIR__.'/../vendor/autoload.php';


$data = ['123', 'test' => 'toto',
         'items' => [
             'jambon' => false,
             'cheese' => true
         ]
];

class CustomFormatter implements \Serializer\Formatter\FormatterInterface{

    public function format(Resource $resource) : array
    {
        echo __METHOD__ . PHP_EOL;

        return [
             'id' => $resource->getId()
        ];
    }
}

class CustomNormalizer implements \Serializer\Normalizer\NormalizerInterface{

    public function normalize($data) : \Serializer\Normalizer\Resource\ResourceInterface
    {
        echo __METHOD__ . PHP_EOL;

        $resource = new Resource();
        $resource->name = $data[0];
        $resource->items = $data['items'];

        return $resource;
    }
}

$serializer = (new Serializer())->setSerializer(new JsonSerializer());
$dataSerialized = $serializer->serialize($data, new CustomFormatter(), new CustomNormalizer());

var_dump($dataSerialized);
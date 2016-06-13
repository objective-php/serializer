<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:09
 */

use Serializer\Schema\JsonApi;
use Serializer\Serializer\JsonSerializer;

require __DIR__.'/../vendor/autoload.php';


$data = ['123', 'test' => 'toto',
         'items' => [
             'jambon' => false,
             'cheese' => true
         ]
];

class CustomSchema implements \Serializer\Schema\SchemaInterface {

    public function transform($data) : array
    {
        return [
             'id' => $data[0],
             'items' => $data['items']
        ];
    }
}

$serializer = new JsonSerializer();
$dataSerialized = $serializer->serialize($data, new CustomSchema());

var_dump($dataSerialized);
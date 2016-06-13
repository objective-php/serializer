<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 17:28
 */

namespace Serializer;


use Serializer\Formatter\FormatterInterface;
use Serializer\Normalizer\NormalizerInterface;
use Serializer\Normalizer\Resource\Resource;
use Serializer\Serializer\JsonSerializer;
use Serializer\Serializer\SerializerInterface;

class Serializer
{

    /** @var  SerializerInterface */
    protected $serializer;

    public function serialize($data, FormatterInterface $formatter, NormalizerInterface $normalizer = null) : string {

        echo __METHOD__ . PHP_EOL;
        
        $serializedData = '';

        if(empty($this->serializer)){
            $this->setSerializer(new JsonSerializer());
        }
        $this->getSerializer()->setFormatter($formatter);

        $normalizedData = $normalizer->normalize($data);
        
        if($normalizedData instanceof Resource){
            $serializedData = $this->getSerializer()->serialize($normalizedData);
        }

        return $serializedData;

    }

    public function setSerializer(SerializerInterface $serializer) : Serializer
    {
        $this->serializer = $serializer;
        return $this;
    }

    public function getSerializer() : SerializerInterface
    {
        return $this->serializer;
    }
}
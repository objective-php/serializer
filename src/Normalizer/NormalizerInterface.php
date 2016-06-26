<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:34
 */

namespace ObjectivePHP\Serializer\Normalizer;


use ObjectivePHP\Serializer\Resource\ResourceInterface;
use ObjectivePHP\Serializer\Resource\SerializableResourceInterface;

/**
 * Interface NormalizerInterface
 * @package ObjectivePHP\Serializer\Normalizer
 */
interface NormalizerInterface
{

    /**
     * @param $data
     *
     * @return SerializableResourceInterface
     */
    public function normalize($data) : SerializableResourceInterface;
}

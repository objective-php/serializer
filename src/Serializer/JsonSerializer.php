<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:20
 */

namespace Serializer\Serializer;


use Serializer\Normalizer\NormalizerInterface;
use Serializer\Schema\SchemaInterface;

class JsonSerializer extends AbstractSerializer
{

    /**
     * @param                          $data
     * @param SchemaInterface          $schema
     * @param NormalizerInterface|null $normalizer
     *
     * @return string
     */
    public function serialize($data, SchemaInterface $schema, NormalizerInterface $normalizer  = null)
    {
        return 'test';
    }

    /**
     * @param string $data
     *
     * @throws \Exception
     */
    public function unserialize($data)
    {
        throw new \Exception('unserialization is not implemented.');
    }
}
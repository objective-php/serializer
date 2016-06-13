<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:37
 */

namespace Serializer\Serializer;


use Serializer\Normalizer\NormalizerInterface;
use Serializer\Schema\SchemaInterface;

interface SerializerInterface
{

    public function serialize($data, SchemaInterface $schema, NormalizerInterface $normalizer = null);

    public function unserialize($data);

}
<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:37
 */

namespace Serializer\Serializer;


use Serializer\Formatter\FormatterInterface;
use Serializer\Normalizer\Resource\ResourceInterface;

interface SerializerInterface
{

    public function serialize(ResourceInterface $data);

    public function unserialize($data) : ResourceInterface;

}

<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:37
 */

namespace Serializer\Encoder;


use Serializer\Normalizer\Resource\ResourceInterface;

interface EncoderInterface
{

    public function encode(ResourceInterface $data) : string ;

    public function unencode($data) : ResourceInterface;

}

<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:34
 */

namespace Serializer\Normalizer;


use Serializer\Normalizer\Resource\ResourceInterface;

/**
 * Interface NormalizerInterface
 * @package Serializer\Normalizer
 */
interface NormalizerInterface
{

    /**
     * @param $data
     *
     * @return ResourceInterface
     */
    public function normalize($data) : ResourceInterface;
}
<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:34
 */

namespace Serializer\Normalizer;


interface NormalizerInterface
{

    public function normalize($data) : NormalizedObject;
}
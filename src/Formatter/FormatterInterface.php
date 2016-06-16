<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:33
 */

namespace Serializer\Formatter;

use Serializer\Normalizer\Resource\Resource;

/**
 * Interface FormatterInterface
 * @package Serializer\Formatter
 */
interface FormatterInterface
{

    /**
     * @param Resource $resource
     *
     * @return array
     */
    public function format(Resource $resource) : array ;
}
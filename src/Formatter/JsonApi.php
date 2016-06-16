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
 * Class JsonApi
 * @package Serializer\Formatter
 */
class JsonApi implements FormatterInterface
{

    /**
     * @param Resource $data
     *
     * @return array
     */
    public function format(Resource $data) : array
    {
        // TODO: Implement transform() method.
        return [];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:20
 */

namespace Serializer\Encoder;


use Serializer\Normalizer\Resource\Resource;
use Serializer\Normalizer\Resource\ResourceInterface;

/**
 * The class JsonEncoder is gonna use the formatter provided to transform
 * a resource into an encoded string.
 *
 * Class JsonEncoder
 * @package Serializer\Encoder
 */
class JsonEncoder extends AbstractEncoder
{

    /**
     * @param ResourceInterface $data
     *
     * @return string
     * @throws \Exception
     */
    public function encode(ResourceInterface $data) : string
    {
        $formatedData = $this->getFormatter()->format($data);

        return json_encode($formatedData);
    }

    /**
     * @param string $data
     *
     * @return ResourceInterface
     * @throws \Exception
     */
    public function unencode($data) : ResourceInterface
    {
        throw new \Exception('unencoding is not implemented.');
    }
}
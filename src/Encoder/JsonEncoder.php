<?php

namespace ObjectivePHP\Serializer\Encoder;


use ObjectivePHP\Serializer\Resource\SerializableResourceInterface;

/**
 * The class JsonEncoder is gonna use the formatter provided to transform
 * a resource into an encoded string.
 *
 * Class JsonEncoder
 * @package ObjectivePHP\Serializer\Encoder
 */
class JsonEncoder extends AbstractEncoder
{

    /**
     * @param SerializableResourceInterface $data
     *
     * @return string
     * @throws \Exception
     */
    public function encode(SerializableResourceInterface $data) : string
    {
        $formattedData = $this->getFormatter()->format($data);

        return json_encode($formattedData);
    }

    /**
     * @param string $data
     *
     * @return mixed
     * @throws Exception
     */
    public function decode($data)
    {
        throw new Exception('decoding is not implemented.');
    }
}

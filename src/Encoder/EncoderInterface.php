<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:37
 */

namespace ObjectivePHP\Serializer\Encoder;


use ObjectivePHP\Serializer\Formatter\FormatterInterface;
use ObjectivePHP\Serializer\Resource\ResourceInterface;
use ObjectivePHP\Serializer\Resource\SerializableResourceInterface;

/**
 * Interface EncoderInterface
 * @package ObjectivePHP\Serializer\Encoder
 */
interface EncoderInterface
{

    /**
     * @param SerializableResourceInterface $data
     *
     * @return string
     */
    public function encode(SerializableResourceInterface $data) : string;

    /**
     * @param $data
     *
     * @return ResourceInterface
     */
    public function decode($data);

    public function getFormatter() : FormatterInterface;

    public function setFormatter(FormatterInterface $formatter);

}

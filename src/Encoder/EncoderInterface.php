<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:37
 */

namespace Serializer\Encoder;


use Serializer\Formatter\FormatterInterface;
use Serializer\Normalizer\Resource\ResourceInterface;

/**
 * Interface EncoderInterface
 * @package Serializer\Encoder
 */
interface EncoderInterface
{

    /**
     * @param ResourceInterface $data
     *
     * @return string
     */
    public function encode(ResourceInterface $data) : string;

    /**
     * @param $data
     *
     * @return ResourceInterface
     */
    public function unencode($data) : ResourceInterface;

    public function getFormatter() : FormatterInterface;

    public function setFormatter(FormatterInterface $formatter);

}

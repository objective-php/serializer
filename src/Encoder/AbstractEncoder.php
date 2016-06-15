<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:21
 */

namespace Serializer\Encoder;


use Serializer\Formatter\FormatterInterface;

abstract class AbstractEncoder implements EncoderInterface
{

    /** @var  FormatterInterface */
    protected $formatter;

    public function getFormatter() : FormatterInterface
    {
        return $this->formatter;
    }

    public function setFormatter(FormatterInterface $formatter) : EncoderInterface
    {
        $this->formatter = $formatter;
        return $this;
    }
}
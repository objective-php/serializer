<?php

namespace ObjectivePHP\Serializer\Encoder;


use ObjectivePHP\Serializer\Formatter\FormatterInterface;

/**
 * Class AbstractEncoder
 * @package Serializer\Encoder
 */
abstract class AbstractEncoder implements EncoderInterface
{

    /** @var  FormatterInterface */
    protected $formatter;

    /**
     * @return FormatterInterface
     */
    public function getFormatter() : FormatterInterface
    {
        return $this->formatter;
    }

    /**
     * @param FormatterInterface $formatter
     *
     * @return EncoderInterface
     */
    public function setFormatter(FormatterInterface $formatter) : EncoderInterface
    {
        $this->formatter = $formatter;

        return $this;
    }
}

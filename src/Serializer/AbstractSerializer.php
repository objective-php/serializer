<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:21
 */

namespace Serializer\Serializer;


use Serializer\Formatter\FormatterInterface;

abstract class AbstractSerializer implements SerializerInterface
{

    /** @var  FormatterInterface */
    protected $formatter;

    public function getFormatter() : FormatterInterface
    {
        return $this->formatter;
    }

    public function setFormatter(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }
}
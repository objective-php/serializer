<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 17:28
 */

namespace Serializer;


use Serializer\Encoder\EncoderInterface;
use Serializer\Encoder\JsonEncoder;
use Serializer\Formatter\FormatterInterface;
use Serializer\Normalizer\NormalizerInterface;
use Serializer\Normalizer\Resource\ResourceInterface;

//TODO: make classes for exception (we're having a lot of differents exceptions now)
class Serializer
{

    /** @var  EncoderInterface */
    protected $encoder;

    /** @var  NormalizerInterface */
    protected $normalizer;

    /** @var  FormatterInterface */
    protected $formatter;

    public function serialize($data) : string
    {
        
        $serializedData = '';

        if (empty($this->encoder)) {
            $this->setEncoder(new JsonEncoder());
        }

        if (empty($this->normalizer)) {
            throw new \Exception("A normalizer has to be set.");
        }

        if (empty($this->formatter)) {
            throw new \Exception("A formatter has to be set.");
        }

        $this->getEncoder()->setFormatter($this->getFormatter());

        $normalizedData = $this->getNormalizer()->normalize($data);

        if ($normalizedData instanceof ResourceInterface) {
            $serializedData = $this->getEncoder()->encode($normalizedData);
        }

        return $serializedData;

    }

    public function getEncoder() : EncoderInterface
    {
        return $this->encoder;
    }

    public function setEncoder(EncoderInterface $encoder) : Serializer
    {
        $this->encoder = $encoder;

        return $this;
    }

    public function getFormatter() : FormatterInterface
    {
        return $this->formatter;
    }

    public function setFormatter(FormatterInterface $formatter) : Serializer
    {
        $this->formatter = $formatter;

        return $this;
    }

    public function getNormalizer() : NormalizerInterface
    {
        return $this->normalizer;
    }

    public function setNormalizer(NormalizerInterface $normalizer) : Serializer
    {
        $this->normalizer = $normalizer;

        return $this;
    }
}
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
use Serializer\Paginer\PaginerInterface;

//TODO: make classes for exception (we're having a lot of differents exceptions now)
/**
 * The class Serializer is the main entry to the library. The class is gonna call
 * the differents adapters.
 *
 * Class Serializer
 * @package Serializer
 */
class Serializer
{

    /** @var  EncoderInterface */
    protected $encoder;

    /** @var  NormalizerInterface */
    protected $normalizer;

    /** @var  FormatterInterface */
    protected $formatter;

    /** @var  PaginerInterface */
    protected $paginer;

    /**
     * Serialize data. it can be anything, you just have to be careful that the
     * normalizer can do his job with your data.
     * the formatter and the encoder can deal with any kind of data.
     *
     * @param $data
     *
     * @return string
     * @throws \Exception
     */
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

        if ($this->getPaginer()) {
            $this->getFormatter()->setPaginer($this->getPaginer());
        }
        $this->getEncoder()->setFormatter($this->getFormatter());

        $normalizedData = $this->getNormalizer()->normalize($data);

        if ($normalizedData instanceof ResourceInterface) {
            $serializedData = $this->getEncoder()->encode($normalizedData);
        }

        return $serializedData;

    }

    /**
     * @return PaginerInterface
     */
    public function getPaginer()
    {
        return $this->paginer;
    }

    /**
     * @param PaginerInterface $paginer
     *
     * @return Serializer
     */
    public function setPaginer($paginer) : Serializer
    {
        $this->paginer = $paginer;

        return $this;
    }

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
     * @return Serializer
     */
    public function setFormatter(FormatterInterface $formatter) : Serializer
    {
        $this->formatter = $formatter;

        return $this;
    }

    /**
     * @return EncoderInterface
     */
    public function getEncoder() : EncoderInterface
    {
        return $this->encoder;
    }

    /**
     * @param EncoderInterface $encoder
     *
     * @return Serializer
     */
    public function setEncoder(EncoderInterface $encoder) : Serializer
    {
        $this->encoder = $encoder;

        return $this;
    }

    /**
     * @return NormalizerInterface
     */
    public function getNormalizer() : NormalizerInterface
    {
        return $this->normalizer;
    }

    /**
     * @param NormalizerInterface $normalizer
     *
     * @return Serializer
     */
    public function setNormalizer(NormalizerInterface $normalizer) : Serializer
    {
        $this->normalizer = $normalizer;

        return $this;
    }
}
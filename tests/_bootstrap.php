<?php
// This is global bootstrap for autoloading


class TestFormatter extends \Serializer\Formatter\AbstractFormatter
{
    /**
     *
     * @param Resource|\Serializer\Normalizer\Resource\Resource $resource
     *
     * @return array
     */
    public function format(\Serializer\Normalizer\Resource\Resource $resource) : array
    {
        $data = ['name' => $resource->getName()];

        if($this->hasPaginer()){
            $data += ['page' => $this->getPaginer()->getCurrentPage()];
        }
        return $data;
    }
}

class TestEncoder extends \Serializer\Encoder\AbstractEncoder
{

    public function encode(\Serializer\Normalizer\Resource\ResourceInterface $data) : string
    {
        return 'encoded data';
    }

    public function unencode($data) : \Serializer\Normalizer\Resource\ResourceInterface
    {
    }
}

class TestNormalizer implements \Serializer\Normalizer\NormalizerInterface{

    public function normalize($data) : \Serializer\Normalizer\Resource\ResourceInterface
    {
        $resource = new \Serializer\Normalizer\Resource\Resource();
        $resource->setName($data['name']);
        $resource->setProperties($data['props']);

        return $resource;
    }
}
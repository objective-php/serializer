<?php
// This is global bootstrap for autoloading


use Serializer\Normalizer\Resource\ResourceInterface;

class TestFormatter extends \Serializer\Formatter\AbstractFormatter
{
    /**
     * @param Resource|\Serializer\Normalizer\Resource\Resource $resource
     *
     * @return array
     */
    public function format(ResourceInterface $resource) : array
    {
        if($resource instanceof \Serializer\Normalizer\Resource\Resource){
            $data = ['name' => $resource->getName()];

            if($this->hasPaginer()){
                $data += ['page' => $this->getPaginer()->getCurrentPage()];
            }
        }else{
            $data = [];
            foreach ($resource as $singleResource) {
                $data[] = ['name' => $singleResource->getName()];
            }

            if($this->hasPaginer()){
                $data += ['page' => $this->getPaginer()->getCurrentPage()];
            }
        }

        return $data;
    }
}

class TestEncoder extends \Serializer\Encoder\AbstractEncoder
{

    public function encode(ResourceInterface $data) : string
    {
        return 'encoded data';
    }

    public function unencode($data) : ResourceInterface
    {
    }
}

class TestNormalizer implements \Serializer\Normalizer\NormalizerInterface{

    public function normalize($data) : ResourceInterface
    {
        $resource = new \Serializer\Normalizer\Resource\Resource();
        $resource->setName($data['name']);
        $resource->setProperties($data['props']);

        return $resource;
    }
}
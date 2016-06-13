<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:20
 */

namespace Serializer\Serializer;


use Serializer\Formatter\FormatterInterface;
use Serializer\Normalizer\Resource\Resource;
use Serializer\Normalizer\Resource\ResourceInterface;
use Serializer\Normalizer\Resource\ResourceSet;

class JsonSerializer extends AbstractSerializer
{

    /**
     * @param ResourceInterface $data
     *
     * @return string
     * @throws \Exception
     */
    public function serialize(ResourceInterface $data) : string
    {
        echo __METHOD__ . PHP_EOL;

        $formatedData = '';
        
        if(!$this->getFormatter() instanceof FormatterInterface){
            throw new \Exception('Invalid Formatter provided. %s', get_class($this->getFormatter()));
        }

        if($data instanceof Resource){

            $formatedData = $this->getFormatter()->format($data);

        }elseif ($data instanceof ResourceSet){

            /** @var Resource $resource */
            foreach ($data as $resource) {
                $formatedData[] = $this->getFormatter()->format($resource);
            }
        }

        return json_encode($formatedData);
    }

    /**
     * @param string $data
     *
     * @return ResourceInterface
     * @throws \Exception
     */
    public function unserialize($data) : ResourceInterface
    {
        throw new \Exception('unserialization is not implemented.');
    }
}
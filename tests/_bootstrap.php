<?php
// This is global bootstrap for autoloading
    
    
    use ObjectivePHP\Serializer\Encoder\AbstractEncoder;
    use ObjectivePHP\Serializer\Formatter\AbstractFormatter;
    use ObjectivePHP\Serializer\Normalizer\NormalizerInterface;
    use ObjectivePHP\Serializer\Resource\Resource;
    use ObjectivePHP\Serializer\Resource\ResourceInterface;
    use ObjectivePHP\Serializer\Resource\SerializableResourceInterface;
    
    /**
     * Class TestFormatter
     */
    class TestFormatter extends AbstractFormatter
    {
        /**
         * @param SerializableResourceInterface $resource
         *
         * @return array
         */
        public function format(SerializableResourceInterface $resource) : array
        {
            if ($resource instanceof Resource)
            {
                $data = ['name' => $resource->getName()];
                
                if ($this->hasPaginator())
                {
                    $data += ['page' => $this->getPaginator()->getCurrentPage()];
                }
            }
            else
            {
                $data = [];
                /** @var ResourceInterface $singleResource */
                foreach ($resource as $singleResource)
                {
                    $data[] = ['name' => $singleResource->getName()];
                }
                
                if ($this->hasPaginator())
                {
                    $data += ['page' => $this->getPaginator()->getCurrentPage()];
                }
            }
            
            return $data;
        }
    }
    
    /**
     * Class TestEncoder
     */
    class TestEncoder extends AbstractEncoder
    {

        /**
         * @param SerializableResourceInterface $data
         *
         * @return string
         */
        public function encode(SerializableResourceInterface $data) : string
        {
            return 'encoded data';
        }

        /**
         * @param $data
         *
         * @return SerializableResourceInterface
         */
        public function decode($data)
        {
        }
    }
    
    /**
     * Class TestNormalizer
     */
    class TestNormalizer implements NormalizerInterface
    {

        /**
         * @param $data
         *
         * @return SerializableResourceInterface
         */
        public function normalize($data) : SerializableResourceInterface
        {
            $resource = new Resource();
            $resource->setName($data['name']);
            $resource->setProperties($data['props']);
            
            return $resource;
        }
    }

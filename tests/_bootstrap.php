<?php
// This is global bootstrap for autoloading
    
    
    use ObjectivePHP\Serializer\Encoder\AbstractEncoder;
    use ObjectivePHP\Serializer\Formatter\AbstractFormatter;
    use ObjectivePHP\Serializer\Normalizer\NormalizerInterface;
    use ObjectivePHP\Serializer\Normalizer\Resource\Resource;
    use ObjectivePHP\Serializer\Normalizer\Resource\ResourceInterface;
    
    /**
     * Class TestFormatter
     */
    class TestFormatter extends AbstractFormatter
    {
        /**
         * @param ResourceInterface|Resource $resource
         *
         * @return array
         */
        public function format(ResourceInterface $resource) : array
        {
            if ($resource instanceof Resource)
            {
                $data = ['name' => $resource->getName()];
                
                if ($this->hasPaginer())
                {
                    $data += ['page' => $this->getPaginer()->getCurrentPage()];
                }
            }
            else
            {
                $data = [];
                foreach ($resource as $singleResource)
                {
                    $data[] = ['name' => $singleResource->getName()];
                }
                
                if ($this->hasPaginer())
                {
                    $data += ['page' => $this->getPaginer()->getCurrentPage()];
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
         * @param ResourceInterface $data
         *
         * @return string
         */
        public function encode(ResourceInterface $data) : string
        {
            return 'encoded data';
        }

        /**
         * @param $data
         *
         * @return ResourceInterface
         */
        public function unencode($data) : ResourceInterface
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
         * @return ResourceInterface
         */
        public function normalize($data) : ResourceInterface
        {
            $resource = new Resource();
            $resource->setName($data['name']);
            $resource->setProperties($data['props']);
            
            return $resource;
        }
    }

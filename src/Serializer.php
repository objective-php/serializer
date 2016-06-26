<?php
    
    namespace ObjectivePHP\Serializer;
    
    
    use ObjectivePHP\Serializer\Encoder\EncoderInterface;
    use ObjectivePHP\Serializer\Encoder\JsonEncoder;
    use ObjectivePHP\Serializer\Formatter\FormatterInterface;
    use ObjectivePHP\Serializer\Normalizer\NormalizerInterface;
    use ObjectivePHP\Serializer\Paginator\PaginatorInterface;
    use ObjectivePHP\Serializer\Resource\ResourceInterface;
    use ObjectivePHP\Serializer\Resource\SerializableResourceInterface;

//TODO: make classes for exception (we're having a lot of differents exceptions now)
    /**
     * The class Serializer is the main entry to the library. The class is gonna call
     * the differents adapters.
     *
     * Class Serializer
     *
     * @package ObjectivePHP\Serializer
     */
    class Serializer
    {
        
        /** @var  EncoderInterface */
        protected $encoder;
        
        /** @var  NormalizerInterface */
        protected $normalizer;
        
        /** @var  FormatterInterface */
        protected $formatter;
        
        /** @var  PaginatorInterface */
        protected $paginator;

        /**
         * Serialize data. it can be anything, you just have to be careful that the
         * normalizer can do his job with your data.
         * the formatter and the encoder can deal with any kind of data.
         *
         * @param $data
         *
         * @return string
         * @throws Exception
         */
        public function serialize($data) : string
        {
            $serializedData = '';

            // inject default encoder
            if (empty($this->encoder))
            {
                $this->setEncoder(new JsonEncoder());
            }
            
            if (empty($this->normalizer))
            {
                throw new Exception("A normalizer has to be set.");
            }
            
            if (empty($this->formatter))
            {
                throw new Exception("A formatter has to be set.");
            }
            
            if ($this->getPaginator())
            {
                $this->getFormatter()->setPaginator($this->getPaginator());
            }
            $this->getEncoder()->setFormatter($this->getFormatter());
            
            $normalizedData = $this->getNormalizer()->normalize($data);

            if ($normalizedData instanceof SerializableResourceInterface)
            {
                $serializedData = $this->getEncoder()->encode($normalizedData);
            }

            return $serializedData;
            
        }
        
        /**
         * @return PaginatorInterface
         */
        public function getPaginator()
        {
            return $this->paginator;
        }
        
        /**
         * @param PaginatorInterface $paginator
         *
         * @return Serializer
         */
        public function setPaginator($paginator) : Serializer
        {
            $this->paginator = $paginator;
            
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

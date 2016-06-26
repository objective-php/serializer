<?php

    namespace ObjectivePHP\Serializer\Resource;


    /**
     * Class AbstractResource
     *
     * @package ObjectivePHP\Serializer\Resource
     */
    abstract class AbstractResource implements ResourceInterface
    {

        /**
         * @var string
         */
        protected $id;

        /**
         * AbstractResource constructor.
         */
        public function __construct()
        {
            $this->id = uniqid();
        }

        /**
         * @return string
         */
        public function getId()
        {
            return $this->id;
        }

    }

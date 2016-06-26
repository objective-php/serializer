<?php

    namespace ObjectivePHP\Serializer\Resource;


    /**
     * Interface ResourceInterface
     *
     * @package ObjectivePHP\Serializer\Resource
     */
    interface ResourceInterface extends SerializableResourceInterface
    {
        /**
         * @return string
         */
        public function getId();

        /**
         * @return string
         */
        public function getName();

        /**
         * @return array
         */
        public function getProperties();

        /**
         * @return string
         */
        public function getBaseUri();


        /**
         * @return string
         */
        public function getClass();


        /**
         * @return array|ResourceSet
         */
        public function getRelations();

    }

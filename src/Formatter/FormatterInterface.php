<?php
    
    namespace ObjectivePHP\Serializer\Formatter;

    use ObjectivePHP\Serializer\Paginator\PaginatorInterface;
    use ObjectivePHP\Serializer\Resource\SerializableResourceInterface;

    /**
     * Interface FormatterInterface
     *
     * @package ObjectivePHP\Serializer\Formatter
     */
    interface FormatterInterface
    {

        /**
         * @param SerializableResourceInterface $resource
         *
         * @return array
         */
        public function format(SerializableResourceInterface $resource) : array;

        /**
         * @return PaginatorInterface
         */
        public function getPaginator() : PaginatorInterface;

        /**
         * @param PaginatorInterface $paginator
         *
         * @return FormatterInterface
         */
        public function setPaginator(PaginatorInterface $paginator);

        /**
         * @return bool
         */
        public function hasPaginator() : bool;
    }

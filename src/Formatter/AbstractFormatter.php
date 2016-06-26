<?php

namespace ObjectivePHP\Serializer\Formatter;


use ObjectivePHP\Serializer\Paginator\PaginatorInterface;

abstract class AbstractFormatter implements FormatterInterface
{
    /** @var  PaginatorInterface */
    protected $paginator;

    public function getPaginator() : PaginatorInterface
    {
        return $this->paginator;
    }

    public function setPaginator(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;

        return $this;
    }

    public function hasPaginator() : bool
    {
        return isset($this->paginator);
    }

}

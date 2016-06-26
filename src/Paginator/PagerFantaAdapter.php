<?php

namespace ObjectivePHP\Serializer\Paginator;


use Pagerfanta\Pagerfanta;

/**
 * Class PagerFantaAdapter
 * @package ObjectivePHP\Serializer\Paginator
 */
class PagerFantaAdapter implements PaginatorInterface
{
    /**
     * @var Pagerfanta
     */
    protected $paginator;


    /**
     * PagerFantaAdapter constructor.
     *
     * @param Pagerfanta $paginator
     */
    public function __construct(Pagerfanta $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * Get the total number of results.
     *
     * @return int
     */
    public function getTotal() : int
    {
        return $this->paginator->count();
    }

    /**
     * Get the number of results on the current page.
     *
     * @return int
     */
    public function getCount() : int
    {
        return count($this->paginator->getCurrentPageResults());
    }

    /**
     * Get the number of results per page.
     *
     * @return int
     */
    public function getPerPage() : int
    {
        return $this->paginator->getMaxPerPage();
    }

    /**
     * Get the last page.
     *
     * @return int
     */
    public function getLastPage() : int
    {
        return $this->paginator->getNbPages();
    }

    /**
     * Get the current page.
     *
     * @return int
     */
    public function getCurrentPage() : int
    {
        return $this->paginator->getCurrentPage();
    }
}

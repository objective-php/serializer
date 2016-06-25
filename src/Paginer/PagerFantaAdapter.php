<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 17/06/2016
 * Time: 09:23
 */

namespace ObjectivePHP\Serializer\Paginer;


use Pagerfanta\Pagerfanta;

/**
 * Class PagerFantaAdapter
 * @package Serializer\Paginer
 */
class PagerFantaAdapter implements PaginerInterface
{
    /**
     * @var Pagerfanta
     */
    protected $paginer;


    /**
     * PagerFantaAdapter constructor.
     *
     * @param Pagerfanta $paginer
     */
    public function __construct(Pagerfanta $paginer)
    {
        $this->paginer = $paginer;
    }

    /**
     * Get the total number of results.
     *
     * @return int
     */
    public function getTotal() : int
    {
        return $this->paginer->count();
    }

    /**
     * Get the number of results on the current page.
     *
     * @return int
     */
    public function getCount() : int
    {
        return count($this->paginer->getCurrentPageResults());
    }

    /**
     * Get the number of results per page.
     *
     * @return int
     */
    public function getPerPage() : int
    {
        return $this->paginer->getMaxPerPage();
    }

    /**
     * Get the last page.
     *
     * @return int
     */
    public function getLastPage() : int
    {
        return $this->paginer->getNbPages();
    }

    /**
     * Get the current page.
     *
     * @return int
     */
    public function getCurrentPage() : int
    {
        return $this->paginer->getCurrentPage();
    }
}

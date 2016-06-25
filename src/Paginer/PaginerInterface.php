<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 17/06/2016
 * Time: 09:15
 */

namespace ObjectivePHP\Serializer\Paginer;


interface PaginerInterface
{

    /**
     * Get the total number of results.
     *
     * @return int
     */
    public function getTotal() : int;

    /**
     * Get the number of results on the current page.
     *
     * @return int
     */
    public function getCount() : int;

    /**
     * Get the number of results per page.
     *
     * @return int
     */
    public function getPerPage() : int;

    /**
     * Get the last page.
     *
     * @return int
     */
    public function getLastPage() : int;

    /**
     * Get the current page.
     *
     * @return int
     */
    public function getCurrentPage() : int;
}

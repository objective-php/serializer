<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 17/06/2016
 * Time: 09:48
 */

namespace Serializer\Formatter;


use Serializer\Paginer\PaginerInterface;

abstract class AbstractFormatter implements FormatterInterface
{
    /** @var  PaginerInterface */
    protected $paginer;

    public function getPaginer() : PaginerInterface
    {
        return $this->paginer;
    }

    public function setPaginer(PaginerInterface $paginer)
    {
        $this->paginer = $paginer;

        return $this;
    }

    public function hasPaginer() : bool
    {
        return isset($this->paginer);
    }


}
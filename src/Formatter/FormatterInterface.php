<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:33
 */

namespace Serializer\Formatter;

use Serializer\Normalizer\Resource\Resource;
use Serializer\Normalizer\Resource\ResourceInterface;
use Serializer\Paginer\PaginerInterface;

/**
 * Interface FormatterInterface
 * @package Serializer\Formatter
 */
interface FormatterInterface
{

    /**
     * @param ResourceInterface $resource
     *
     * @return array
     */
    public function format(ResourceInterface $resource) : array;

    /**
     * @return PaginerInterface
     */
    public function getPaginer() : PaginerInterface;

    /**
     * @param PaginerInterface $paginer
     *
     * @return FormatterInterface
     */
    public function setPaginer(PaginerInterface $paginer);

    /**
     * @return bool
     */
    public function hasPaginer() : bool;
}
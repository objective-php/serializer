<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 16:49
 */

namespace Serializer\Normalizer\Resource;


class AbstractResource implements ResourceInterface
{

    protected $id;

    /**
     * AbstractResource constructor.
     */
    public function __construct()
    {
        $this->id = uniqid();
    }

    public function getId()
    {
        return $this->id;
    }

}
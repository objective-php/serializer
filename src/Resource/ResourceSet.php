<?php

namespace ObjectivePHP\Serializer\Resource;


use ObjectivePHP\Serializer\Resource\Resource;
use Traversable;

/**
 * Class ResourceSet
 * @package ObjectivePHP\Serializer\Resource
 */
class ResourceSet implements \IteratorAggregate, SerializableResourceInterface
{
    /** @var array */
    protected $resources;

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

    /**
     * @param ResourceInterface $resource
     *
     * @return ResourceSet
     */
    public function addChild(ResourceInterface $resource) : ResourceSet
    {
        $this->resources[$resource->getId()] = $resource;

        return $this;
    }

    /**
     * @param $id
     *
     * @return ResourceSet
     * @throws \Exception
     */
    public function removeChild($id) : ResourceSet
    {
        if (!isset($this->resources[$id])) {
            throw new \Exception(sprintf('There is no ressource with the id %s', $id));
        }

        unset($this->resources[$id]);

        return $this;
    }

    /**
     * @param $id
     *
     * @return ResourceInterface
     * @throws Exception
     */
    public function getResource($id) : ResourceInterface
    {
        if (!isset($this->resources[$id])) {
            throw new Exception(sprintf('There is no resource with id "%s"', $id));
        }

        return $this->resources[$id];
    }

    /**
     * @return array
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * Retrieve an external iterator
     * @link  http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->resources);
    }
}

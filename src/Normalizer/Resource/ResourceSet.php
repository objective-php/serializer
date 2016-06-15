<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 14:55
 */

namespace Serializer\Normalizer\Resource;


use Traversable;

class ResourceSet extends AbstractResource implements \IteratorAggregate
{

    /** @var  int */
    protected $position;

    /** @var array */
    protected $resources;

    public function addChild(Resource $resource) : ResourceSet
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
        if(!isset($this->resources[$id])) throw new \Exception(sprintf('There is no ressource with the id %s', $id));

        unset($this->resources[$id]);
        return$this;
    }

    /**
     * @param $id
     *
     * @return Resource
     * @throws \Exception
     */
    public function getResource($id) : Resource
    {
        if(!isset($this->resources[$id])) throw new \Exception(sprintf('There is no ressource with the id %s', $id));

        return $this->resources[$id];
    }

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
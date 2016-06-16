<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 14:55
 */

namespace Serializer\Normalizer\Resource;

class Resource extends AbstractResource
{

    /** @var  string */
    protected $name;

    /** @var  array */
    protected $properties;

    /** @var  array */
    protected $relations;

    /** @var  string */
    protected $baseUri;

    /** @var  string */
    protected $class;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Resource
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param array $properties
     *
     * @return Resource
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * @return string
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * @param string $baseUri
     *
     * @return Resource
     */
    public function setBaseUri(string $baseUri)
    {
        $this->baseUri = $this->formatBaseUri($baseUri);

        return $this;
    }

    protected function formatBaseUri(string $uri = null) : string
    {
        if (empty($uri)) {
            $uri = 'http://example.com/api/';
        }

        if (substr($uri, -1) != '/') {
            $uri .= '/';
        }

        //TODO: do other checks

        return strtolower($uri);
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     *
     * @return Resource
     */
    public function setClass(string $class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return array
     */
    public function getRelations()
    {
        return $this->relations;
    }

    /**
     * @param array $relations
     *
     * @return Resource
     */
    public function setRelations($relations)
    {
        $this->relations = $relations;

        return $this;
    }

}
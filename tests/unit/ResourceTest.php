<?php

use Serializer\Normalizer\Resource\Resource;

class ResourceTest extends \Codeception\TestCase\Test
{
    /**
     * @var CodeGuy
     */
    protected $tester;

    /** @var  Resource */
    protected $resource;

    function _before()
    {
        $this->resource = new Resource();
    }

    function testResourceIsAResource(){
        $this->assertInstanceOf(\Serializer\Normalizer\Resource\ResourceInterface::class, $this->resource);
    }

    function testResourceHaveAnUniqueId()
    {
        $this->assertNotNull($this->resource);
    }
}

<?php
    
    use Codeception\TestCase\Test;
    use ObjectivePHP\Serializer\Resource\ResourceSet;
    use ObjectivePHP\Serializer\Resource\Resource;
    use ObjectivePHP\Serializer\Resource\ResourceInterface;
    use ObjectivePHP\Serializer\Resource\SerializableResourceInterface;
    
    class ResourceTest extends Test
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /** @var  Resource */
    protected $resource;

    /** @var  ResourceSet */
    protected $resourceSet;

    function _before()
    {
        $this->resource = new Resource();
        $this->resourceSet = new ResourceSet();
    }

    function testResourceIsAResource(){
        $this->assertInstanceOf(ResourceInterface::class, $this->resource);
    }

    function testResourceHaveAnUniqueId()
    {
        $this->assertNotNull($this->resource->getId());
    }

    public function testResourceHasWorkingGetters()
    {
        $this->resource
            ->setName('resource test')
            ->setProperties([1,2,3])
            ->setClass(Resource::class)
            ->setBaseUri('http://test.test/');

        $this->assertEquals('resource-test', $this->resource->getName());
        $this->assertEquals([1,2,3], $this->resource->getProperties());
        $this->assertEquals(Resource::class, $this->resource->getClass());
        $this->assertEquals('http://test.test/', $this->resource->getBaseUri());
    }

    public function testResourceIsFormattingBaseUri()
    {
        $this->resource->setBaseUri('');

        $this->assertEquals('http://example.com/api/', $this->resource->getBaseUri());

        $this->resource->setBaseUri('http://test.COm');

        $this->assertEquals('http://test.com/', $this->resource->getBaseUri());
    }

    public function testResourceSetIsAResource()
    {
        $this->assertInstanceOf(SerializableResourceInterface::class, $this->resourceSet);
    }

    function testResourceSetHaveAnUniqueId()
    {
        $this->assertNotNull($this->resourceSet->getId());
    }

    public function testResourceSetCanAddChilds()
    {
        $resource1 = new Resource();
        $resource2 = new Resource();

        $this->resourceSet->addChild($resource1);
        $this->resourceSet->addChild($resource2);

        $this->assertContains($resource1, $this->resourceSet->getResources());
        $this->assertContains($resource2, $this->resourceSet->getResources());
    }

    public function testResourceSetCanRemoveChildren()
    {
        $resource1 = new Resource();

        $this->tester->assertThrows(function () {
            $this->resourceSet->removeChild('reallyInvalidId');
        }, 'Exception', 'An exception as to be thrown.');

        $this->resourceSet->addChild($resource1);

        $this->assertContains($resource1, $this->resourceSet->getResources());

        $this->resourceSet->removeChild($resource1->getId());

        $this->assertNotContains($resource1, $this->resourceSet->getResources());
        
    }

    public function testResourceSetCanGetAResourceChild()
    {
        $resource1 = new Resource();

        $this->resourceSet->addChild($resource1);

        $this->assertEquals($resource1, $this->resourceSet->getResource($resource1->getId()));

        $this->tester->assertThrows(function () {
            $this->resourceSet->getResource('reallyInvalidId');
        }, 'Exception', 'An exception as to be thrown.');


    }

}

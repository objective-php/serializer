<?php
    
    
    use ObjectivePHP\Serializer\Formatter\DataArray;
    use ObjectivePHP\Serializer\Formatter\JsonApi;
    use ObjectivePHP\Serializer\Resource\ResourceSet;
    use ObjectivePHP\Serializer\Resource\Resource;
    
    class FormatterTest extends \Codeception\TestCase\Test
{
    /**
     * @var UnitTester
     */
    protected $tester;

    function _before()
    {
    }

    public function testDataArrayFormatter()
    {
        $dataArray = new DataArray();
        $resource1 = (new Resource())
            ->setName('wow')
            ->setProperties(['such' => 'relation'])
        ;
        $resource = (new \ObjectivePHP\Serializer\Resource\Resource())
            ->setName('test')
            ->setRelations((new ResourceSet())->addChild($resource1))
        ;

        $formatedData = $dataArray->format($resource);

        $this->assertInstanceOf(\ObjectivePHP\Serializer\Formatter\FormatterInterface::class, $dataArray);
        $this->assertEquals(
            ['resource_id' => $resource->getId(),
             'test' => ['data' => null],
             'relations' => [['wow' => ['data' => ['such' => 'relation']]]]
            ], $formatedData);
    }

    public function testFormatterIsFormatting()
    {
        $formatter = new TestFormatter();
        $resource = (new Resource())->setName('resource name');

        $formattedData = $formatter->format($resource);

        $this->assertTrue(is_array($formattedData));
        $this->assertEquals(['name' => 'resource-name'], $formattedData);

    }

    public function testJsonApiFormatter()
    {
        $formatter = new JsonApi();
        $resource = (new Resource())->setName('resource name');

        $formattedData = $formatter->format($resource);

        $this->assertTrue(is_array($formattedData));
        $this->assertEquals([
            'links' => ["self" => 'http://example.com/api/resource-name'],
            'data' => [
                'type' => 'resource-name',
                'id' => null,
                'attributes' => null,
                'links' => ['self' => 'http://example.com/api/resource-name/']
            ]
        ], $formattedData);
    }

    public function testJsonApiFormatterWithPagination()
    {
        $resources = \Codeception\Util\Stub::factory(\ObjectivePHP\Serializer\Resource\Resource::class, 15);

        //TODO: do an other test with pagination
        //$formatter->setPaginer(new \ObjectivePHP\Serializer\Paginer\PagerFantaAdapter(new \Pagerfanta\Pagerfanta(new \Pagerfanta\Adapter\ArrayAdapter([$resource]))));

    }


}

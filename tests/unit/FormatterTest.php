<?php


use Serializer\Formatter\DataArray;
use Serializer\Formatter\JsonApi;
use Serializer\Normalizer\Resource\Resource;

class FormatterTest extends \Codeception\TestCase\Test
{
    /**
     * @var CodeGuy
     */
    protected $tester;

    function _before()
    {
    }

    public function testDataArrayFormatter()
    {
        $dataArray = new DataArray();
        $resource = (new Resource())
            ->setName('test')
            ->setRelations(['wow' => ['such' => 'relation']])
        ;

        $formatedData = $dataArray->format($resource);

        $this->assertInstanceOf(\Serializer\Formatter\FormatterInterface::class, $dataArray);
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
        $this->assertEquals(['name' => 'resource name'], $formattedData);

    }

    public function testJsonApiFormatter()
    {
        $formatter = new JsonApi();
        $resource = (new Resource())->setName('resource name');

        $formattedData = $formatter->format($resource);
        
        $this->assertTrue(is_array($formattedData));
    }


}

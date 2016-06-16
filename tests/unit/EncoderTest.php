<?php


use Serializer\Normalizer\Resource\Resource;
use Serializer\Normalizer\Resource\ResourceSet;

class EncoderTest extends \Codeception\TestCase\Test
{
    /**
     * @var UnitTester
     */
    protected $tester;

    function _before()
    {
    }

    public function testJsonEncoder()
    {
        $encoder = new \Serializer\Encoder\JsonEncoder();
        
        $resource = (new Resource())->setName('resource test');
        $resourceSet = (new ResourceSet())->addChild($resource);
        
        $encoder->setFormatter(new TestFormatter());
        $encodedData = $encoder->encode($resource);

        $this->assertEquals('{"name":"resource test"}', $encodedData);

        $encodedData = $encoder->encode($resourceSet);
        $this->assertEquals('[{"name":"resource test"}]', $encodedData);


        $this->tester->assertThrows(function ()  use ($encoder){
            $encoder->unencode('somethingsomething');
        }, 'Exception', 'An exception as to be thrown.');

    }

    public function testEncoder()
    {
        $encoder = new TestEncoder();

        $resource = \Codeception\Util\Stub::make(Resource::class);
        $encoder->setFormatter(new TestFormatter());
        $encodedData = $encoder->encode($resource);

        $this->assertInstanceOf(\Serializer\Encoder\EncoderInterface::class, $encoder);
        $this->assertInstanceOf(\Serializer\Formatter\FormatterInterface::class, $encoder->getFormatter());
        $this->assertEquals(TestFormatter::class, get_class($encoder->getFormatter()));
        $this->assertEquals('encoded data', $encodedData);
    }
}



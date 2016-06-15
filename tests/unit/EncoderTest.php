<?php


use Serializer\Normalizer\Resource\Resource;

class EncoderTest extends \Codeception\TestCase\Test
{
    /**
     * @var CodeGuy
     */
    protected $tester;

    function _before()
    {
    }

    public function testJsonEncoder()
    {
        $encoder = new \Serializer\Encoder\JsonEncoder();
        /** @var Resource $resource */
        $resource = \Codeception\Util\Stub::make(Resource::class, ['getId' => '123']);

        //TODO: need to finish the resourceSet for this test
        $resourceSet = \Codeception\Util\Stub::make(\Serializer\Normalizer\Resource\ResourceSet::class);

        $encoder->setFormatter(new TestFormatter());
        $encodedData = $encoder->encode($resource);

        $this->assertEquals('{"id":"123"}', $encodedData);

    }

    public function testEncoder()
    {
        $encoder = new TestEncoder();

        $resource = \Codeception\Util\Stub::make(Resource::class, ['getId' => '123']);
        $encoder->setFormatter(new TestFormatter());
        $encodedData = $encoder->encode($resource);

        $this->assertInstanceOf(\Serializer\Encoder\EncoderInterface::class, $encoder);
        $this->assertInstanceOf(\Serializer\Formatter\FormatterInterface::class, $encoder->getFormatter());
        $this->assertEquals(TestFormatter::class, get_class($encoder->getFormatter()));
        $this->assertEquals('encoded data', $encodedData);
    }
}



class TestFormatter implements \Serializer\Formatter\FormatterInterface
{

    public function format(Resource $resource) : array
    {
        return ['id' => $resource->getId()];
    }
}

class TestEncoder extends \Serializer\Encoder\AbstractEncoder
{

    public function encode(\Serializer\Normalizer\Resource\ResourceInterface $data) : string
    {
        return 'encoded data';
    }

    public function unencode($data) : \Serializer\Normalizer\Resource\ResourceInterface
    {
    }
}


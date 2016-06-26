<?php
    
    
    use Codeception\TestCase\Test;
    use Codeception\Util\Stub;
    use ObjectivePHP\Serializer\Encoder\JsonEncoder;
    use ObjectivePHP\Serializer\Resource\ResourceSet;
    use ObjectivePHP\Serializer\Resource\Resource;
    use Pagerfanta\Adapter\ArrayAdapter;
    use Pagerfanta\Pagerfanta;
    
    class EncoderTest extends Test
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
            $encoder = new JsonEncoder();

            $resource    = (new Resource())->setName('resource test');
            $resourceSet = (new ResourceSet())->addChild($resource);

            $encoder->setFormatter(new TestFormatter());
            $encodedData = $encoder->encode($resource);

            $this->assertEquals('{"name":"resource-test"}', $encodedData);

            $encodedData = $encoder->encode($resourceSet);
            $this->assertEquals('[{"name":"resource-test"}]', $encodedData);

            $this->tester->assertThrows(function () use ($encoder)
            {
                $encoder->decode('somethingsomething');
            }, 'Exception', 'An exception as to be thrown.');

        }

        public function testEncoderPaginate()
        {
            $resource = Stub::make(Resource::class);
            $encoder  = new JsonEncoder();
            $fomatter = (new TestFormatter())->setPaginator(
                new \ObjectivePHP\Serializer\Paginator\PagerFantaAdapter(
                    new Pagerfanta(
                        new ArrayAdapter([])
                    )
                )
            );
            $encoder->setFormatter($fomatter);
            $encodedData = $encoder->encode($resource);

            $this->assertEquals('{"name":null,"page":1}', $encodedData);


        }

        public function testEncoder()
        {
            $encoder = new TestEncoder();

            $resource = Stub::make(Resource::class);
            $encoder->setFormatter(new TestFormatter());
            $encodedData = $encoder->encode($resource);

            $this->assertInstanceOf(\ObjectivePHP\Serializer\Encoder\EncoderInterface::class, $encoder);
            $this->assertInstanceOf(\ObjectivePHP\Serializer\Formatter\FormatterInterface::class, $encoder->getFormatter());
            $this->assertEquals(TestFormatter::class, get_class($encoder->getFormatter()));
            $this->assertEquals('encoded data', $encodedData);
        }
    }



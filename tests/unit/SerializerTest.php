<?php


    use ObjectivePHP\Serializer\Encoder\JsonEncoder;
    use ObjectivePHP\Serializer\Paginator\PagerFantaAdapter;
    use ObjectivePHP\Serializer\Serializer;
    use Pagerfanta\Adapter\ArrayAdapter;
    use Pagerfanta\Pagerfanta;
    use ObjectivePHP\Serializer\Encoder\EncoderInterface;
    use ObjectivePHP\Serializer\Formatter\FormatterInterface;
    use ObjectivePHP\Serializer\Normalizer\NormalizerInterface;

    class SerializerTest extends \Codeception\TestCase\Test
    {
        /**
         * @var UnitTester
         */
        protected $tester;

        /** @var  \Doctrine\ORM\EntityManager */
        protected $entityManager;

        /** @var  NormalizerInterface */
        protected $normalizer;

        /** @var  FormatterInterface */
        protected $formatter;

        /** @var  EncoderInterface */
        protected $encoder;


        protected $testData;

        function _before()
        {
            $this->entityManager = $this->getModule('Doctrine2')->em;

            $this->normalizer = new TestNormalizer();
            $this->formatter  = new TestFormatter();
            $this->encoder    = new JsonEncoder();

            $this->testData = ['name' => 'data', 'props' => ['prop1' => 'val1', 'prop2' => 'val2']];
        }

        public function testSerializer()
        {
            $serializer = new Serializer();

            $serializer->setPaginator(
                new PagerFantaAdapter(
                    new Pagerfanta(
                        new ArrayAdapter([$this->testData]))
                )
            );

            $this->tester->assertThrows(function () use ($serializer)
            {
                $serializer->serialize('somethingsomething');
            }, 'Exception', 'An exception as to be thrown.');

            $serializer->setNormalizer($this->normalizer);

            $this->tester->assertThrows(function () use ($serializer)
            {
                $serializer->serialize('somethingsomething');
            }, 'Exception', 'An exception as to be thrown.');

            $serializer->setFormatter($this->formatter);
            $serializer->setEncoder($this->encoder);

            $serializedData = $serializer->serialize($this->testData);


            $this->assertEquals('{"name":"data","page":1}', $serializedData);
        }
    }

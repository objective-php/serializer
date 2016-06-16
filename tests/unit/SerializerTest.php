<?php


use Serializer\Artist;
use Serializer\Encoder\JsonEncoder;
use Serializer\Normalizer\DoctrineNormalizer;
use Serializer\Serializer;

class SerializerTest extends \Codeception\TestCase\Test
{
    /**
     * @var CodeGuy
     */
    protected $tester;

    /** @var  \Doctrine\ORM\EntityManager */
    protected $entityManager;

    /** @var  \Serializer\Normalizer\NormalizerInterface */
    protected $normalizer;
    /** @var  \Serializer\Formatter\FormatterInterface */
    protected $formatter;
    /** @var  \Serializer\Encoder\EncoderInterface */
    protected $encoder;


    protected $testData;

    function _before()
    {
        $this->entityManager = $this->getModule('Doctrine2')->em;

        $this->normalizer = new TestNormalizer();
        $this->formatter = new TestFormatter();
        $this->encoder = new JsonEncoder();

        $this->testData = ['name' => 'data', 'props' => ['prop1' => 'val1', 'prop2' => 'val2']];
    }

    public function testSerializer()
    {
        $serializer = new Serializer();


        $this->tester->assertThrows(function () use ($serializer){
            $serializer->serialize('somethingsomething');
        }, 'Exception', 'An exception as to be thrown.');

        $serializer->setNormalizer($this->normalizer);
        
        $this->tester->assertThrows(function () use ($serializer){
            $serializer->serialize('somethingsomething');
        }, 'Exception', 'An exception as to be thrown.');

        $serializer->setFormatter($this->formatter);
        $serializer->setEncoder($this->encoder);

        $serializedData = $serializer->serialize($this->testData);


        $this->assertEquals('{"name":"data"}', $serializedData);
    }
}

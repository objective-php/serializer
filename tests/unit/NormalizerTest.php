<?php


class NormalizerTest extends \Codeception\TestCase\Test
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /** @var  \Doctrine\ORM\EntityManager */
    protected $em;
    /** @var  \Serializer\examples\Album */
    protected $album;
    /** @var  array */
    protected $albums;

    function _before()
    {
        $this->em = $this->getModule('Doctrine2')->em;
        $this->albums = $this->em->getRepository(\Serializer\examples\Album::class)->findBy(['id' => [1,2, 3, 4]]);
        $this->album = $this->em->getRepository(\Serializer\examples\Album::class)->find(1);
    }

    public function testDoctrineNormalizer()
    {
        $normalizer = new \Serializer\Normalizer\DoctrineNormalizer();

        $normalizer->setBaseUri('http://example.com/');

        $this->tester->assertThrows(function () use ($normalizer){
            $normalizer->normalize('somethingsomething');
        }, 'Exception', 'An exception as to be thrown.');

        $normalizer->setEntityManager($this->em);

        $resource = $normalizer->normalize($this->album);

        $this->assertEquals('http://example.com/', $normalizer->getBaseUri());
        $this->assertInstanceOf(\Serializer\Normalizer\Resource\Resource::class, $resource);
        $this->assertEquals($this->em, $normalizer->getEntityManager());

        $resourceSet = $normalizer->normalize($this->albums);

        $this->assertInstanceOf(\Serializer\Normalizer\Resource\ResourceSet::class, $resourceSet);


    }
}

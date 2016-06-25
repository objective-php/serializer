<?php
    
    
    use Doctrine\ORM\EntityManager;
    use Doctrine\ORM\EntityRepository;
    use Doctrine\ORM\Mapping\ClassMetadata;
    use ObjectivePHP\Serializer\Normalizer\DoctrineNormalizer;
    use ObjectivePHP\Serializer\Normalizer\Resource\Resource;
    use ObjectivePHP\Serializer\Normalizer\Resource\ResourceSet;
    use Tests\Example\Album;
    use Tests\Example\Artist;
    
    class NormalizerTest extends \Codeception\TestCase\Test
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /** @var  EntityManager */
    protected $em;
    /** @var  Album */
    protected $album;
    /** @var  array */
    protected $albums;

    function _before()
    {

        $this->em = $this->getModule('Doctrine2')->em;
        /*
        $artist1 = $this->createArtist(1, 'First Artist');
        $artist2 = $this->createArtist(1, 'Second Artist');

        $album1 = $this->createAlbum(1, 'First Album', $artist1);
        $album2 = $this->createAlbum(2, 'Second Album', $artist2);
        $album3 = $this->createAlbum(2, 'Third Album', $artist2);
        $album4 = $this->createAlbum(2, 'Fourth Album', $artist2);


        $em = $this->createMock(EntityManager::class);

        $albumRepository = $this->getMockBuilder(EntityRepository::class)->disableOriginalConstructor()->setMethods(['find', 'findBy', 'getClassMetadata'])->getMock();
        $albumRepository->setEntityManager($em);
        $albumRepository->expects($this->any())->method('getClassMetadata')->with(Album::class)->willReturn($this->createAlbumMetadata());
        $albumRepository->expects($this->any())->method('find')->with(1)->willReturn($album1);
        $albumRepository->expects($this->any())->method('findBy')->with(['id' => [1, 2, 3, 4]])->willReturn([$album1, $album2, $album3, $album4]);


        $em->expects($this->any())->method('getRepository')->with(Album::class)->willReturn($albumRepository);


        $this->em = $em;
            */

        $this->albums = $this->em->getRepository(Album::class)->findBy(['id' => [1, 2, 3, 4]]);
        $this->album = $this->em->getRepository(Album::class)->find(1);
    }

    public function testDoctrineNormalizer()
    {
        $normalizer = new DoctrineNormalizer();

        $normalizer->setBaseUri('http://example.com/');

        $this->tester->assertThrows(function () use ($normalizer){
            $normalizer->normalize('somethingsomething');
        }, 'Exception', 'An exception as to be thrown.');

        $normalizer->setEntityManager($this->em);

        $resource = $normalizer->normalize($this->album);

        $this->assertEquals('http://example.com/', $normalizer->getBaseUri());
        $this->assertInstanceOf(Resource::class, $resource);
        $this->assertEquals($this->em, $normalizer->getEntityManager());

        $resourceSet = $normalizer->normalize($this->albums);

        $this->assertInstanceOf(ResourceSet::class, $resourceSet);


    }
        
        protected function createAlbum($id, $title, Artist $artist)
        {
            $album = new Album;
            $reflectedAlbum = new ReflectionObject($album);
            $reflectedId = $reflectedAlbum->getProperty('id');
            $reflectedId->setAccessible(true);
            $reflectedId->setValue($album, $id);
            $reflectedId->setAccessible(false);

            $album->setTitle($title);
            $album->setArtist($artist);
            
            return $album;
            
        }
        
        protected function createArtist($id, $name)
        {
            $artist = new Artist;
            $reflectedArtist = new ReflectionObject($artist);
            $reflectedId = $reflectedArtist->getProperty('id');
            $reflectedId->setAccessible(true);
            $reflectedId->setValue($artist, $id);
            $reflectedId->setAccessible(false);

            $artist->setName($name);

            return $artist;
            
        }

    protected function createAlbumMetadata()
    {
        $metadata = $this->createMock(ClassMetadata::class);

        $metadata->namespace = 'Tests\Example';
        $metadata->name = 'Album';

        $metadataFactory = new \Doctrine\ORM\Mapping\ClassMetadataFactory();
        $metadata = $metadataFactory->getMetadataFor(Album::class);

        var_dump($metadata);

        return $metadata;
    }
}

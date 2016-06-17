<?php


use Serializer\Artist;
use Serializer\Encoder\JsonEncoder;
use Serializer\Normalizer\DoctrineNormalizer;
use Serializer\Serializer;

class PaginerTest extends \Codeception\TestCase\Test
{
    /**
     * @var UnitTester
     */
    protected $tester;

    function _before()
    {
    }

    public function testPaginerFantaAdapter()
    {
        $resources = \Codeception\Util\Stub::factory(\Serializer\Normalizer\Resource\Resource::class, 35);
        $arrayAdapter = new \Pagerfanta\Adapter\ArrayAdapter($resources);
        $pager = new \Pagerfanta\Pagerfanta($arrayAdapter);

        $pagerAdapter = new \Serializer\Paginer\PagerFantaAdapter($pager);

        $pager->setCurrentPage(4);
        $pager->setMaxPerPage(10);

        $this->assertEquals(4, $pagerAdapter->getCurrentPage());
        $this->assertEquals(10, $pagerAdapter->getPerPage());
        $this->assertEquals(35, $pagerAdapter->getTotal());
        $this->assertEquals(5, $pagerAdapter->getCount());
        $this->assertEquals(4, $pagerAdapter->getLastPage());

    }
}

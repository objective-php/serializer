<?php
    
    
    use Codeception\TestCase\Test;
    use Codeception\Util\Stub;
    use ObjectivePHP\Serializer\Artist;
    use ObjectivePHP\Serializer\Paginator\PagerFantaAdapter;
    use ObjectivePHP\Serializer\Resource\Resource;
    use Pagerfanta\Adapter\ArrayAdapter;
    use Pagerfanta\Pagerfanta;
    
    class PaginerTest extends Test
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
            $resources    = Stub::factory(Resource::class, 35);
            $arrayAdapter = new ArrayAdapter($resources);
            $pager        = new Pagerfanta($arrayAdapter);

            $pagerAdapter = new PagerFantaAdapter($pager);

            $pager->setCurrentPage(4);
            $pager->setMaxPerPage(10);

            $this->assertEquals(4, $pagerAdapter->getCurrentPage());
            $this->assertEquals(10, $pagerAdapter->getPerPage());
            $this->assertEquals(35, $pagerAdapter->getTotal());
            $this->assertEquals(5, $pagerAdapter->getCount());
            $this->assertEquals(4, $pagerAdapter->getLastPage());

        }
    }

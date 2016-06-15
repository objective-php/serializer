<?php


use Serializer\Artist;
use Serializer\Encoder\JsonEncoder;
use Serializer\Serializer;

class SerializerTest extends \Codeception\TestCase\Test
{
    /**
     * @var CodeGuy
     */
    protected $tester;

    /** @var  \Doctrine\ORM\EntityManager */
    protected $entityManager;

    function _before()
    {
    }
}

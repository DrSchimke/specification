<?php

namespace Sci\Tests\Specification;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

abstract class SpecificationTestCase extends \PHPUnit_Framework_TestCase
{
    /** @var QueryBuilder */
    protected $queryBuilder;

    protected function setUp()
    {
        $em = $this->getMock(EntityManagerInterface::class);
        $this->queryBuilder = new QueryBuilderMock($em);
        $this->queryBuilder->select('a')->from('A', 'a');
    }

    /**
     * @return \Doctrine\ORM\Query\Expr\Join[]
     */
    protected function getJoins()
    {
        /** @var Join[][] $joinParts */
        $joinParts = $this->queryBuilder->getDQLPart('join');
        $this->assertArrayHasKey('a', $joinParts);
        $this->assertArrayHasKey('0', $joinParts['a']);

        return $joinParts['a'];
    }
}

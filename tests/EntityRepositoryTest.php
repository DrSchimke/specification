<?php

namespace Sci\Tests\Specification;

use Sci\Specification\EntityRepository;
use Sci\Specification\Result\ResultSpecification;
use Sci\Specification\Specification;

/**
 * @group unitTest
 * @group specificationPattern
 */
class EntityRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var EntityRepository|\PHPUnit_Framework_MockObject_MockObject */
    private $entityRepository;

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMatchThrowsException()
    {
        $entityName = 'Entity\Name';

        $this->entityRepository->expects($this->any())->method('getEntityName')->willReturn($entityName);

        $specification = $this->getMock(Specification::class);
        $specification->expects($this->once())->method('supports')->with($entityName)->willReturn(false);

        $this->entityRepository->match($specification);
    }

    public function testMatch()
    {
        $entityName = 'Entity\Name';
        $expectedResult = 'result';

        $expression = $this->getMock(\Doctrine\ORM\Query\Expr\Base::class);

        $query = $this->getMockBuilder(\Doctrine\ORM\AbstractQuery::class)
                ->disableOriginalConstructor()
                ->getMock();
        $query->expects($this->once())->method('getResult')->willReturn($expectedResult);

        $queryBuilder = $this->getMockBuilder('Doctrine\ORM\QueryBuilder')
                ->disableOriginalConstructor()
                ->getMock();
        $queryBuilder->expects($this->once())->method('where')->with($expression);
        $queryBuilder->expects($this->once())->method('getQuery')->willReturn($query);

        $specification = $this->getMock(Specification::class);
        $specification->expects($this->once())->method('supports')->with($entityName)->willReturn(true);
        $specification->expects($this->once())->method('match')->with($queryBuilder)->willReturn($expression);

        $this->entityRepository->expects($this->any())->method('getEntityName')->willReturn($entityName);
        $this->entityRepository->expects($this->any())->method('createQueryBuilder')->willReturn($queryBuilder);

        $result = $this->entityRepository->match($specification);

        $this->assertSame($expectedResult, $result);
    }

    public function testMatchForResultSpecification()
    {
        $entityName = 'Entity\Name';
        $expectedResult = 'result';

        $expression = $this->getMock('Doctrine\ORM\Query\Expr\Base');

        $query = $this->getMockBuilder(\Doctrine\ORM\AbstractQuery::class)
                ->disableOriginalConstructor()
                ->getMock();

        $queryBuilder = $this->getMockBuilder('Doctrine\ORM\QueryBuilder')
                ->disableOriginalConstructor()
                ->getMock();
        $queryBuilder->expects($this->once())->method('where')->with($expression);
        $queryBuilder->expects($this->once())->method('getQuery')->willReturn($query);

        $specification = $this->getMock(ResultSpecification::class);
        $specification->expects($this->once())->method('supports')->with($entityName)->willReturn(true);
        $specification->expects($this->once())->method('match')->with($queryBuilder)->willReturn($expression);
        $specification->expects($this->once())->method('getResult')->with($query)->willReturn($expectedResult);

        $this->entityRepository->expects($this->any())->method('getEntityName')->willReturn($entityName);
        $this->entityRepository->expects($this->any())->method('createQueryBuilder')->willReturn($queryBuilder);

        $result = $this->entityRepository->match($specification);

        $this->assertSame($expectedResult, $result);
    }

    protected function setUp()
    {
        $this->entityRepository = $this->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['getEntityName', 'createQueryBuilder'])
            ->getMock();
    }
}

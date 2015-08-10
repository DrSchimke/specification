<?php

namespace Sci\Tests\Specification\Result;

use Sci\Specification\Result\OneOrNull;
use Sci\Tests\Specification\SpecificationTestCase;

/**
 * @group unitTest
 * @group specificationPattern
 */
class OneOrNullTest extends SpecificationTestCase
{
    public function testMatch()
    {
        // arrange
        $alias = 'a';
        $expected = 'expected result';

        $child = $this->getMockBuilder('Sci\Specification\Specification')->getMock();
        $child->expects($this->once())->method('match')->with($this->queryBuilder, $alias)->willReturn($expected);

        // act
        $specification = new OneOrNull($child);
        $result = $specification->match($this->queryBuilder, $alias);

        // assert
        $this->assertEquals($expected, $result);
    }

    public function testSupports()
    {
        // arrange
        $entityName = 'Foo\Bar\EntityName';
        $expectedResult = true;

        $child = $this->getMockBuilder('Sci\Specification\Specification')->getMock();
        $child->expects($this->once())->method('supports')->with($entityName)->willReturn($expectedResult);

        // act
        $specification = new OneOrNull($child);
        $result = $specification->supports($entityName);

        // assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetResult()
    {
        // arrange
        $expectedResult = 'result';

        $query = $this->getMockBuilder('Doctrine\ORM\AbstractQuery')
            ->disableOriginalConstructor()
            ->setMethods(['getOneOrNullResult'])
            ->getMockForAbstractClass();
        $query->expects($this->once())->method('getOneOrNullResult')->willReturn($expectedResult);

        $child = $this->getMockBuilder('Sci\Specification\Specification')->getMock();

        // act
        $specification = new \Sci\Specification\Result\OneOrNull($child);
        $result = $specification->getResult($query);

        // assert
        $this->assertEquals($expectedResult, $result);
    }
}

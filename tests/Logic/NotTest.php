<?php

namespace Sci\Tests\Specification\Logic;

use Sci\Specification\Logic\Not;
use Sci\Specification\Specification;
use Sci\Tests\Specification\SpecificationTestCase;
use Sci\Tests\Specification\TestSpecification;

/**
 * @group unitTest
 * @group specificationPattern
 */
class NotTest extends SpecificationTestCase
{
    public function testMatch()
    {
        // arrange
        $child = new TestSpecification('foo');

        // act
        $specification = new Not($child);
        $expression = $specification->match($this->queryBuilder, 'a');

        // assert
        $this->assertEquals('NOT(foo)', (string) $expression);
    }

    public function testSupports()
    {
        $entityName = 'Entity\Name';
        $expectedResult = 'expected result';

        $child = $this->getMock(Specification::class);
        $child->expects($this->once())->method('supports')->with($entityName)->willReturn($expectedResult);

        $specification = new Not($child);

        $this->assertEquals($expectedResult, $specification->supports($entityName));
    }
}

<?php

namespace Sci\Tests\Specification\Logic;

use Sci\Specification\Logic\OrX;
use Sci\Tests\Specification\SpecificationTestCase;
use Sci\Tests\Specification\TestSpecification;

/**
 * @group unitTest
 * @group specificationPattern
 */
class OrXTest extends SpecificationTestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionOnNoChildren()
    {
        new OrX([]);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionOnInvalidChild()
    {
        $notASpecification = new \stdClass();

        new OrX([$notASpecification]);
    }

    public function testMatch()
    {
        // arrange
        $child1 = new TestSpecification('foo');
        $child2 = new TestSpecification('bar');

        // act
        $specification = new OrX([$child1, $child2]);
        $expression = $specification->match($this->queryBuilder, 'a');

        // assert
        $this->assertEquals('foo OR bar', (string) $expression);
    }

    public function testSupportsReturnsTrue()
    {
        // arrange
        $entityName = 'Entity\Name';

        $child1 = $this->getMockBuilder('Sci\Specification\Specification')->getMock();
        $child1->expects($this->once())->method('supports')->with($entityName)->willReturn(true);

        $child2 = $this->getMockBuilder('Sci\Specification\Specification')->getMock();
        $child2->expects($this->once())->method('supports')->with($entityName)->willReturn(true);

        // act
        $specification = new OrX([$child1, $child2]);

        $result = $specification->supports($entityName);

        // assert
        $this->assertTrue($result);
    }

    public function testSupportsReturnsFalse()
    {
        // arrange
        $entityName = 'Entity\Name';

        $child1 = $this->getMockBuilder('Sci\Specification\Specification')->getMock();
        $child1->expects($this->once())->method('supports')->with($entityName)->willReturn(false);

        $child2 = $this->getMockBuilder('Sci\Specification\Specification')->getMock();
        $child2->expects($this->never())->method('supports');

        // act
        $specification = new OrX([$child1, $child2]);

        $result = $specification->supports($entityName);

        // assert
        $this->assertFalse($result);
    }
}

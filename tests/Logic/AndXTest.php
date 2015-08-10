<?php

namespace Sci\Tests\Specification\Logic;

use Sci\Specification\Logic\AndX;
use Sci\Specification\Specification;
use Sci\Tests\Specification\SpecificationTestCase;
use Sci\Tests\Specification\TestSpecification;

/**
 * @group unitTest
 * @group specificationPattern
 */
class AndXTest extends SpecificationTestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsException()
    {
        new AndX([]);
    }

    public function testMatch()
    {
        // arrange
        $child1 = new TestSpecification('foo');
        $child2 = new TestSpecification('bar');

        // act
        $specification = new AndX([$child1, $child2]);
        $expression = $specification->match($this->queryBuilder, 'a');

        // assert
        $this->assertEquals('foo AND bar', (string) $expression);
    }

    public function testSupportsReturnsTrue()
    {
        $entityName = 'Entity\Name';

        $child1 = $this->getMock(Specification::class);
        $child1->expects($this->any())->method('supports')->with($entityName)->willReturn(true);

        $child2 = $this->getMock(Specification::class);
        $child2->expects($this->any())->method('supports')->with($entityName)->willReturn(true);

        $specification = new AndX([$child1, $child2]);

        $this->assertTrue($specification->supports($entityName));
    }

    public function testSupportsReturnsFalse()
    {
        $entityName = 'Entity\Name';

        $child1 = $this->getMock(Specification::class);
        $child1->expects($this->any())->method('supports')->with($entityName)->willReturn(true);

        $child2 = $this->getMock(Specification::class);
        $child2->expects($this->any())->method('supports')->with($entityName)->willReturn(false);

        $specification = new AndX([$child1, $child2]);

        $this->assertFalse($specification->supports($entityName));
    }
}

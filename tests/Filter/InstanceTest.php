<?php

namespace Sci\Tests\Specification\Filter;

use Sci\Tests\Specification\SpecificationTestCase;

/**
 * @group unitTest
 * @group specificationPattern
 */
class InstanceTest extends SpecificationTestCase
{
    /**
     * SELECT o FROM Order AS o WHERE o.foo INSTANCE OF FOO\Bar\Blubb.
     */
    public function testMatchMainEntityProperty()
    {
        $className = 'Foo\Bar\Blubb';

        // act
        $specification = new TestInstanceSpecification('foo', $className);
        $expression = $specification->match($this->queryBuilder, 'o');

        // assert
        $this->assertEquals('o.foo INSTANCE OF '.$className, (string) $expression);
    }

    /**
     * SELECT o FROM Order AS o JOIN o.volumes AS v WHERE v.product INSTANCE OF FOO\Bar\Blubb.
     */
    public function testMatchJoinedEntityProperty()
    {
        $className = 'Foo\Bar\Blubb';

        // act
        $specification = new TestInstanceSpecification('o.volumes', $className);
        $expression = $specification->match($this->queryBuilder, 'o');

        // assert
        $this->assertEquals('o.volumes INSTANCE OF '.$className, (string) $expression);
    }

    /**
     * SELECT o FROM Order AS o JOIN o.volumes AS v WHERE v INSTANCE OF FOO\Bar\Blubb.
     */
    public function testMatchJoinedEntity()
    {
        $className = 'Foo\Bar\Blubb';

        // act
        $specification = new TestInstanceSpecification('v', $className, false);
        $expression = $specification->match($this->queryBuilder, 'o');

        // assert
        $this->assertEquals('v INSTANCE OF '.$className, (string) $expression);
    }
}

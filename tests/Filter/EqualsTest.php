<?php

namespace Sci\Tests\Specification\Filter;

use Sci\Tests\Specification\SpecificationTestCase;

/**
 * @group unitTest
 * @group specificationPattern
 */
class EqualsTest extends SpecificationTestCase
{
    public function testMatch()
    {
        $value = 'bar';

        // act
        $specification = new TestEqualsSpecification('foo', $value);
        $expression    = $specification->match($this->queryBuilder, 'a');

        // assert
        $parameterName = $specification->getParameterName();
        $this->assertEquals('a.foo = :' . $parameterName, (string) $expression);

        $parameter = $this->queryBuilder->getParameter($parameterName);
        $this->assertNotNull($parameter);
        $this->assertEquals($value, $parameter->getValue());
    }
}

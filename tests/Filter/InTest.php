<?php

namespace Sci\Tests\Specification\Filter;

use Sci\Tests\Specification\SpecificationTestCase;

/**
 * @group unitTest
 * @group specificationPattern
 */
class InTest extends SpecificationTestCase
{
    public function testMatch()
    {
        $values = [1, 2, 3];

        // act
        $specification = new TestInSpecification('foo', $values);
        $expression    = $specification->match($this->queryBuilder, 'a');

        // assert
        $parameterName = $specification->getParameterName();
        $this->assertEquals('a.foo IN(:' . $parameterName . ')', (string) $expression);

        $parameter = $this->queryBuilder->getParameter($parameterName);
        $this->assertNotNull($parameter);
        $this->assertEquals($values, $parameter->getValue());
    }

    public function testMatchEmptyList()
    {
        $values = [];

        // act
        $specification = new TestInSpecification('foo', $values);
        $expression    = $specification->match($this->queryBuilder, 'a');

        // assert
        $this->assertEquals('0 = 1', (string) $expression);
    }
}

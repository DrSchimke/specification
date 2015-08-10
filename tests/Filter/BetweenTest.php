<?php

namespace Sci\Tests\Specification\Filter;

use Sci\Tests\Specification\SpecificationTestCase;

/**
 * @group unitTest
 * @group specificationPattern
 */
class BetweenTest extends SpecificationTestCase
{
    public function testMatch()
    {
        $from = 11;
        $to = 20;

        // act
        $specification = new TestBetweenSpecification('foo', $from, $to);
        $expression    = $specification->match($this->queryBuilder, 'a');

        // assert
        $parameterFrom = $specification->getParameterFrom();
        $parameterTo = $specification->getParameterTo();

        $this->assertEquals(sprintf('a.foo BETWEEN :%s AND :%s', $parameterFrom, $parameterTo), (string) $expression);

        $parameter = $this->queryBuilder->getParameter($parameterFrom);
        $this->assertNotNull($parameter);
        $this->assertEquals($from, $parameter->getValue());

        $parameter = $this->queryBuilder->getParameter($parameterTo);
        $this->assertNotNull($parameter);
        $this->assertEquals($to, $parameter->getValue());
    }
}

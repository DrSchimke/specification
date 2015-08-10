<?php

namespace Sci\Tests\Specification\Filter;

use Sci\Tests\Specification\SpecificationTestCase;

/**
 * @group unitTest
 * @group specificationPattern
 */
class OverlapsTest extends SpecificationTestCase
{
    public function test()
    {
        $dateFrom = new \DateTime('2015-01-01');
        $dateTo = new \DateTime('2015-01-14');

        $specification = new TestOverlapsSpecification('columnFrom', 'columnTo', $dateFrom, $dateTo);

        $expression = $specification->match($this->queryBuilder, 'a');
        $parameterNameFrom = $specification->getParameterNameFrom();
        $parameterNameTo = $specification->getParameterNameTo();

        $this->assertEquals(
            'a.columnFrom <= :'. $parameterNameTo .' AND a.columnTo >= :'. $parameterNameFrom,
            (string) $expression
        );
        $this->assertEquals($dateFrom, $this->queryBuilder->getParameter($parameterNameFrom)->getValue());
        $this->assertEquals($dateTo, $this->queryBuilder->getParameter($parameterNameTo)->getValue());
    }
}

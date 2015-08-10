<?php

namespace Sci\Tests\Specification\Filter;

use Sci\Specification\Filter\Between;

class TestBetweenSpecification extends Between
{
    public function supports($entityName)
    {
        return true;
    }
}

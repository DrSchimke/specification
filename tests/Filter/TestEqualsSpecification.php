<?php

namespace Sci\Tests\Specification\Filter;

use Sci\Specification\Filter\Equals;

class TestEqualsSpecification extends Equals
{
    public function supports($entityName)
    {
        return true;
    }
}

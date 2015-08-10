<?php

namespace Sci\Tests\Specification\Filter;

use Sci\Specification\Filter\In;

class TestInSpecification extends In
{
    public function supports($entityName)
    {
        return true;
    }
}

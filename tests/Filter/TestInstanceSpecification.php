<?php

namespace Sci\Tests\Specification\Filter;

use Sci\Specification\Filter\Instance;

class TestInstanceSpecification extends Instance
{
    public function supports($entityName)
    {
        return true;
    }
}

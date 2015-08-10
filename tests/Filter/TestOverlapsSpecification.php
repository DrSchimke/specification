<?php

namespace Sci\Tests\Specification\Filter;

use Sci\Specification\Filter\Overlaps;

class TestOverlapsSpecification extends Overlaps
{
    public function supports($entityName)
    {
        return true;
    }
}

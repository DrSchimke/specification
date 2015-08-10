<?php

namespace Sci\Specification\Result;

use Doctrine\ORM\AbstractQuery;
use Sci\Specification\Specification;

interface ResultSpecification extends Specification
{
    /**
     * @param AbstractQuery $query
     *
     * @return mixed
     */
    public function getResult(AbstractQuery $query);
}

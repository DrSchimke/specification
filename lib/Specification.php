<?php

namespace Sci\Specification;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

interface Specification
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $alias
     *
     * @return mixed|Expr\Base
     */
    public function match(QueryBuilder $queryBuilder, $alias);

    /**
     * @param string $entityName
     *
     * @return bool
     */
    public function supports($entityName);
}

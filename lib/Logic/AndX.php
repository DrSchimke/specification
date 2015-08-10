<?php

namespace Sci\Specification\Logic;

use Doctrine\ORM\QueryBuilder;
use Sci\Specification\Specification;

class AndX extends Composite
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $alias
     *
     * @return mixed
     */
    public function match(QueryBuilder $queryBuilder, $alias)
    {
        $childExpressions = array_map(function (Specification $specification) use ($queryBuilder, $alias) {
            return $specification->match($queryBuilder, $alias);
        }, $this->children);

        return call_user_func_array([$queryBuilder->expr(), 'andX'], $childExpressions);
    }
}

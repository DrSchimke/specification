<?php

namespace Sci\Tests\Specification;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class QueryBuilderMock extends QueryBuilder
{
    private $expressionBuilder;

    /**
     * @return Query\Expr
     */
    public function expr()
    {
        if ($this->expressionBuilder === null) {
            $this->expressionBuilder = new Query\Expr;
        }

        return $this->expressionBuilder;

    }
}

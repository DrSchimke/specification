<?php

namespace Sci\Specification\Result;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Sci\Specification\Specification;

class Limit implements Specification
{
    /** @var Specification */
    private $child;

    /** @var int */
    private $limit;

    /**
     * @param Specification $child
     * @param int           $limit
     */
    public function __construct(Specification $child, $limit)
    {
        $this->child = $child;
        $this->limit = $limit;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $alias
     *
     * @return mixed|Expr\Base
     */
    public function match(QueryBuilder $queryBuilder, $alias)
    {
        $queryBuilder->setMaxResults($this->limit);

        return $this->child->match($queryBuilder, $alias);
    }

    /**
     * @param string $entityName
     *
     * @return bool
     */
    public function supports($entityName)
    {
        return $this->child->supports($entityName);
    }
}

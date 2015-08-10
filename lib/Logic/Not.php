<?php

namespace Sci\Specification\Logic;

use Doctrine\ORM\QueryBuilder;
use Sci\Specification\Specification;

class Not implements Specification
{
    /**
     * @var Specification
     */
    private $child;

    /**
     * @param Specification $child
     */
    public function __construct(Specification $child)
    {
        $this->child = $child;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $alias
     *
     * @return mixed
     */
    public function match(QueryBuilder $queryBuilder, $alias)
    {
        $childExpression = $this->child->match($queryBuilder, $alias);

        return $queryBuilder->expr()->not($childExpression);
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

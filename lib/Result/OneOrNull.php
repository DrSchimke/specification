<?php

namespace Sci\Specification\Result;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Sci\Specification\Specification;

class OneOrNull implements Specification, ResultSpecification
{
    /** @var Specification */
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

    /**
     * @param AbstractQuery $query
     *
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function getResult(AbstractQuery $query)
    {
        return $query->getOneOrNullResult();
    }
}

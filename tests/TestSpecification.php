<?php

namespace Sci\Tests\Specification;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Sci\Specification\Specification;

class TestSpecification implements Specification
{
    /** @var string */
    private $foo;

    /**
     * @param string $foo
     */
    public function __construct($foo)
    {
        $this->foo = $foo;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $alias
     *
     * @return Query\Expr\Base
     */
    public function match(QueryBuilder $queryBuilder, $alias)
    {
        return $this->foo;
    }

    /**
     * @param string $entityName
     *
     * @return bool
     */
    public function supports($entityName)
    {
        return true;
    }
}

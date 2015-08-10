<?php

namespace Sci\Specification;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

abstract class Base implements Specification
{
    private static $counter = 0;
    private static $parameters = [];

    protected function createUniqueParameterName($column)
    {
        $key = sprintf('%s::%s', get_class($this), $column);

        if (!isset(self::$parameters[$key])) {
            self::$parameters[$key] = 'a'.++self::$counter;
        }

        return self::$parameters[$key];
    }

    /**
     * Adds a join statement to query builder, if it does not yet exist.
     *
     * If a second JOIN of the same entity is needed, use another just $joinTableAlias.
     *
     * Usage:
     *   $this->join($queryBuilder, 'o.volume', 'v') INSTEAD OF $queryBuilder->join($join, $joinTableAlias)
     *
     * @param QueryBuilder $queryBuilder
     * @param string       $join           e.g. 'o.volume'
     * @param string       $joinTableAlias e.g. 'v'
     */
    protected function join(QueryBuilder $queryBuilder, $join, $joinTableAlias, $conditionType = null, $condition = null)
    {
        $alias = explode('.', $join)[0];

        /** @var Join[][] $joinParts */
        $joinParts = $queryBuilder->getDQLPart('join');

        if (isset($joinParts[$alias]) && is_array($joinParts[$alias])) {
            foreach ($joinParts[$alias] as $joinPart) {
                if ($joinTableAlias == $joinPart->getAlias()) {
                    return;
                }
            }
        }

        $queryBuilder->join($join, $joinTableAlias, $conditionType, $condition);
    }
}

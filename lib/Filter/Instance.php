<?php

namespace Sci\Specification\Filter;

use Doctrine\ORM\QueryBuilder;
use Sci\Specification\Base;

/**
 * Filter specification for DQL clause 'INSTANCE OF'.
 */
abstract class Instance extends Base
{
    /** @var string */
    private $field;

    /** @var string */
    private $className;

    /** @var bool */
    private $property;

    /**
     * @param string $field
     * @param string $className
     * @param bool   $property
     */
    public function __construct($field, $className, $property = true)
    {
        $this->field = $field;
        $this->className = $className;
        $this->property = $property;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $alias
     *
     * @return mixed
     */
    public function match(QueryBuilder $queryBuilder, $alias)
    {
        $column = $this->field;
        if ($this->property && false === strpos($this->field, '.')) {
            $column = $alias.'.'.$column;
        }

        return sprintf('%s INSTANCE OF %s', $column, $this->className);
    }
}

<?php

namespace Sci\Specification\Filter;

use Doctrine\ORM\QueryBuilder;
use Sci\Specification\Base;

abstract class In extends Base
{
    /** @var string */
    private $column;

    /** @var array */
    protected $values;

    /** @var string */
    private $type;

    /** @var string */
    private $parameterName;

    /**
     * @param string $column
     * @param array  $values
     * @param string $type
     */
    public function __construct($column, array $values, $type = null)
    {
        $this->column = $column;
        $this->values = $values;
        $this->type   = $type;

        $this->parameterName = $this->createUniqueParameterName($column);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $alias
     *
     * @return mixed
     */
    public function match(QueryBuilder $queryBuilder, $alias)
    {
        if ($this->values) {
            $queryBuilder->setParameter($this->parameterName, $this->values, $this->type);

            $column = $this->column;
            if (false === strpos($this->column, '.')) {
                $column = $alias . '.' . $column;
            }

            $expression = $queryBuilder->expr()->in($column, ':' . $this->parameterName);
        } else {
            $expression = $queryBuilder->expr()->eq(0, 1);
        }

        return $expression;
    }

    /**
     * @return string
     */
    public function getParameterName()
    {
        return $this->parameterName;
    }
}

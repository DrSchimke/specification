<?php

namespace Sci\Specification\Filter;

use Doctrine\ORM\QueryBuilder;
use Sci\Specification\Base;

abstract class Equals extends Base
{
    /** @var string */
    private $field;

    /** @var mixed */
    protected $value;

    /** @var string */
    private $paramType;

    /** @var string */
    private $parameterName;

    /**
     * @param string $field
     * @param mixed  $value
     * @param string $paramType
     */
    public function __construct($field, $value, $paramType = null)
    {
        $this->field = $field;
        $this->value = $value;
        $this->paramType = $paramType;

        $this->parameterName = $this->createUniqueParameterName($field);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $alias
     *
     * @return mixed
     */
    public function match(QueryBuilder $queryBuilder, $alias)
    {
        $queryBuilder->setParameter($this->parameterName, $this->value, $this->paramType);

        $column = $this->field;
        if (false === strpos($this->field, '.')) {
            $column = $alias.'.'.$column;
        }

        return $queryBuilder->expr()->eq($column, ':'.$this->parameterName);
    }

    /**
     * @return string
     */
    public function getParameterName()
    {
        return $this->parameterName;
    }
}

<?php

namespace Sci\Specification\Filter;

use Doctrine\ORM\QueryBuilder;
use Sci\Specification\Base;

abstract class Between extends Base
{
    /** @var string */
    private $field;

    /** @var mixed */
    protected $from;

    /** @var mixed */
    protected $to;

    /** @var string */
    private $type;

    /** @var string */
    private $parameterFrom;

    /** @var string */
    private $parameterTo;

    /**
     * @param string $field
     * @param mixed  $from
     * @param mixed  $to
     * @param string $type
     */
    public function __construct($field, $from, $to, $type = null)
    {
        $this->field = $field;
        $this->from   = $from;
        $this->to     = $to;
        $this->type   = $type;

        $this->parameterFrom = $this->createUniqueParameterName('from');
        $this->parameterTo   = $this->createUniqueParameterName('to');
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $alias
     *
     * @return mixed
     */
    public function match(QueryBuilder $queryBuilder, $alias)
    {
        $queryBuilder->setParameter($this->parameterFrom, $this->from);
        $queryBuilder->setParameter($this->parameterTo, $this->to);

        $column = $this->field;
        if (false === strpos($this->field, '.')) {
            $column = $alias . '.' . $column;
        }

        return $queryBuilder->expr()->between($column, ':' . $this->parameterFrom, ':' . $this->parameterTo);
    }

    /**
     * @return string
     */
    public function getParameterFrom()
    {
        return $this->parameterFrom;
    }

    /**
     * @return string
     */
    public function getParameterTo()
    {
        return $this->parameterTo;
    }
}

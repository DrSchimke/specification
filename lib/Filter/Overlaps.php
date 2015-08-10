<?php

namespace Sci\Specification\Filter;

use Doctrine\ORM\QueryBuilder;
use Sci\Specification\Base;

abstract class Overlaps extends Base
{
    /** @var string */
    private $fieldFrom;

    /** @var string */
    private $fieldTo;

    /** @var mixed */
    protected $valueFrom;

    /** @var mixed */
    protected $valueTo;

    /** @var string */
    private $parameterNameFrom;

    /** @var string */
    private $parameterNameTo;

    /** @var string */
    private $paramType;

    /**
     * @param string $fieldFrom
     * @param string $fieldTo
     * @param mixed  $valuefrom
     * @param mixed  $valueTo
     * @param null   $paramType
     */
    public function __construct($fieldFrom, $fieldTo, $valuefrom, $valueTo, $paramType = null)
    {
        $this->fieldFrom = $fieldFrom;
        $this->fieldTo = $fieldTo;
        $this->valueFrom = $valuefrom;
        $this->valueTo = $valueTo;
        $this->paramType = $paramType;

        $this->parameterNameFrom = $this->createUniqueParameterName($fieldFrom);
        $this->parameterNameTo = $this->createUniqueParameterName($fieldTo);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $alias
     *
     * @return mixed
     */
    public function match(QueryBuilder $queryBuilder, $alias)
    {
        $queryBuilder->setParameter($this->parameterNameFrom, $this->valueFrom, $this->paramType);
        $queryBuilder->setParameter($this->parameterNameTo, $this->valueTo, $this->paramType);

        $column1 = $this->getColumn($alias, $this->fieldFrom);
        $column2 = $this->getColumn($alias, $this->fieldTo);

        return $queryBuilder->expr()->andX(
            $queryBuilder->expr()->lte($column1, ':'.$this->parameterNameTo),
            $queryBuilder->expr()->gte($column2, ':'.$this->parameterNameFrom)
        );
    }

    /**
     * @return string
     */
    public function getParameterNameFrom()
    {
        return $this->parameterNameFrom;
    }

    /**
     * @return string
     */
    public function getParameterNameTo()
    {
        return $this->parameterNameTo;
    }

    /**
     * @param string $alias
     * @param string $field
     *
     * @return string
     */
    private function getColumn($alias, $field)
    {
        $column = $field;

        if (false === strpos($field, '.')) {
            $column = $alias.'.'.$column;
        }

        return $column;
    }
}

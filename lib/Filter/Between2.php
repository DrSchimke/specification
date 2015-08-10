<?php

namespace Sci\Specification\Filter;

use Doctrine\ORM\QueryBuilder;
use Sci\Specification\Base;

/**
 * @codeCoverageIgnore
 * wird erstmal nicht verwendet
 */
abstract class Between2 extends Base
{
    /** @var string */
    private $fieldFrom;

    /** @var string */
    private $fieldTo;

    /** @var mixed */
    private $value;

    /** @var string */
    private $type;

    /** @var string */
    private $parameterName;

    /**
     * @param string $fieldFrom
     * @param string $fieldTo
     * @param mixed  $value
     * @param string $type
     */
    public function __construct($fieldFrom, $fieldTo, $value, $type = null)
    {
        $this->fieldFrom = $fieldFrom;
        $this->fieldTo   = $fieldTo;
        $this->value     = $value;
        $this->type      = $type;

        $this->parameterName = $this->createUniqueParameterName('value');
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $alias
     *
     * @return mixed
     */
    public function match(QueryBuilder $queryBuilder, $alias)
    {
        $queryBuilder->setParameter($this->parameterName, $this->value);

        $columnFrom = (false === strpos($this->fieldFrom, '.')) ? $alias . '.' . $this->fieldFrom : $this->fieldFrom;
        $columnTo   = (false === strpos($this->fieldTo, '.'))   ? $alias . '.' . $this->fieldTo   : $this->fieldTo;

        return $queryBuilder->expr()->between(':' . $this->parameterName, $columnFrom, $columnTo);
    }

    /**
     * @return string
     */
    public function getParameterName()
    {
        return $this->parameterName;
    }
}

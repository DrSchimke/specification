<?php

namespace Sci\Specification;

use Doctrine\ORM\EntityRepository as BaseRepository;
use Sci\Specification\Result\ResultSpecification;

class EntityRepository extends BaseRepository
{
    const CLASS_NAME = __CLASS__;

    /**
     * @param Specification $specification
     *
     * @return mixed
     */
    public function match(Specification $specification)
    {
        if (! $specification->supports($this->getEntityName())) {
            throw new \InvalidArgumentException('Specification not supported by this repository.');
        }

        $alias        = 'base_entity_alias';
        $queryBuilder = $this->createQueryBuilder($alias);

        $expression = $specification->match($queryBuilder, $alias);

        $queryBuilder->where($expression);

        $query = $queryBuilder->getQuery();

        if ($specification instanceof ResultSpecification) {
            $result = $specification->getResult($query);
        } else {
            $result = $query->getResult();
        }

        return $result;
    }
}

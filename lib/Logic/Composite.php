<?php

namespace Sci\Specification\Logic;

use Sci\Specification\Base;
use Sci\Specification\Specification;

abstract class Composite extends Base
{
    /** @var Specification[] */
    protected $children;

    /**
     * @param Specification[] $children
     */
    public function __construct(array $children)
    {
        if (!$children) {
            throw new \InvalidArgumentException('No arguments');
        }

        foreach ($children as $idx => $child) {
            if (!$child instanceof Specification) {
                throw new \InvalidArgumentException(sprintf('Argument %d is not a specification', $idx));
            }
        }

        $this->children = $children;
    }

    /**
     * @param string $entityName
     *
     * @return bool
     */
    public function supports($entityName)
    {
        foreach ($this->children as $child) {
            if (!$child->supports($entityName)) {
                return false;
            }
        }

        return true;
    }
}

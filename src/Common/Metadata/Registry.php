<?php

declare(strict_types=1);

namespace Sandbox\Common\Metadata;

/**
 * The Registry holds all generated extension ClassMetadata,
 * for retrieval by extension listeners.
 */
class Registry
{
    private $metadata = [];

    public function hasMetadata(string $class): bool
    {
        return isset($this->metadata[$class]);
    }

    public function getMetadata(string $class): ClassExtensionMetadata
    {
        if ( ! $this->hasMetadata($class)) {
            throw new \InvalidArgumentException('ClassMetadata not found for class' . $class);
        }

        return $this->metadata[$class];
    }

    public function addMetadata(ClassExtensionMetadata $metadata): void
    {
        $this->metadata[$metadata->getClass()] = $metadata;
    }
}

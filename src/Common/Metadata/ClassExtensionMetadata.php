<?php

declare(strict_types=1);

namespace Sandbox\Common\Metadata;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;

/**
 * The ClassMetadata class holds all of the extension configuration
 * for a specific class.
 */
class ClassExtensionMetadata
{
    /**
     * @var ClassMetadata
     */
    private $classMetadata;

    /**
     * A list of the active Extensions used by this class.
     * Used by extension listeners to determine if they need
     * to take any action with this class.
     *
     * @var array|ExtensionMetadata[]
     */
    private $extensions = [];

    public function __construct(ClassMetadata $classMetadata)
    {
        $this->classMetadata = $classMetadata;
    }

    public function getClass(): string
    {
        return $this->classMetadata->getName();
    }

    public function addExtension(ExtensionMetadata $metadata): void
    {
        $this->extensions[$metadata->getExtensionName()] = $metadata;
    }

    public function getExtension(string $extension): ExtensionMetadata
    {
        if ( ! $this->usesExtension($extension)) {
            throw new \InvalidArgumentException('Class does not utilize extension "'.$extension.'"');
        }

        return $this->extensions[$extension];
    }

    public function usesExtension(string $extension): bool
    {
        return isset($this->extensions[$extension]);
    }
}

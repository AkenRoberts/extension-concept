<?php

declare(strict_types=1);

namespace Sandbox\Common\Metadata;

/**
 * The ClassMetadata class holds all of the extension configuration
 * for a specific class.
 */
class ClassExtensionMetadata
{
    /**
     * @var string
     */
    private $class;

    /**
     * A list of the active Extensions used by this class.
     * Used by extension listeners to determine if they need
     * to take any action with this class.
     *
     * @var array|ExtensionMetadata[]
     */
    private $extensions = [];

    public function __construct(string $class)
    {
        $this->class = $class;
    }

    public function getClass(): string
    {
        return $this->class;
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

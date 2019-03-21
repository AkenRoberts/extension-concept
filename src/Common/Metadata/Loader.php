<?php

declare(strict_types=1);

namespace Sandbox\Common\Metadata;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Sandbox\Timestampable\TimestampableMetadata;

/**
 * The Metadata Loader will parse the metadata configuration for all
 * activated extensions, and save that Metadata to a custom class for
 * easy reference by extension event listeners.
 */
class Loader implements EventSubscriber
{
    /**
     * @var Registry
     */
    private $registry;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    public function getSubscribedEvents(): array
    {
        return [
            'loadClassMetadata',
        ];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {
        // Here is where we would grab the appropriate metadata driver
        // (annotation, YAML, etc.) and parse the class, checking for
        // extension metadata.

        // The goal is to "activate" extensions, so that only those we've
        // decided to use are looked for and parsed. The activation process
        // also sets the listeners for doing the actual data manipulation.

        // An alternative to explore is to create generated Entity Listeners.
        // These listeners would be entity-specific instead of extension-specific,
        // and be generated to include all listeners and modifications for
        // applied extensions.

        $classExtensionMetadata = new ClassExtensionMetadata($eventArgs->getClassMetadata());

        $timestampable = new TimestampableMetadata();
        $timestampable->addOnCreateField('createdAt');
        $timestampable->addOnCreateField('updatedAt');
        $timestampable->addOnUpdateField('updatedAt');

        $classExtensionMetadata->addExtension($timestampable);

        $this->registry->addMetadata($classExtensionMetadata);
    }
}

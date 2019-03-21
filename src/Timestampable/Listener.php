<?php

declare(strict_types=1);

namespace Sandbox\Timestampable;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Lcobucci\Clock\Clock;
use Lcobucci\Clock\SystemClock;
use Sandbox\Common\Metadata\Registry;

class Listener implements EventSubscriber
{
    private const EXTENSION = 'Timestampable';

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var Clock
     */
    private $clock;

    public function __construct(Registry $registry, ?Clock $clock = null)
    {
        $this->registry = $registry;
        $this->clock = $clock ?: new SystemClock();
    }

    public function getSubscribedEvents(): array
    {
        return [
            'onFlush',
        ];
    }

    public function onFlush(OnFlushEventArgs $eventArgs): void
    {
        $em = $eventArgs->getEntityManager();
        $unitOfWork = $em->getUnitOfWork();

        // Check new entities to be created.
        foreach ($unitOfWork->getScheduledEntityInsertions() as $entity) {
            $entityClass = \get_class($entity);
            $extensionClassMetadata = $this->registry->getMetadata($entityClass);

            if ( ! $extensionClassMetadata->usesExtension(self::EXTENSION)) {
                continue;
            }

            /** @var TimestampableMetadata $timestampableMetadata */
            $timestampableMetadata = $extensionClassMetadata->getExtension(self::EXTENSION);

            if ( ! $timestampableMetadata->hasOnCreateFields()) {
                continue;
            }

            $classMeta = $em->getClassMetadata($entityClass);

            foreach ($timestampableMetadata->getOnCreateFields() as $field) {
                $property = $classMeta->getReflectionProperty($field);
                $property->setValue($entity, $this->clock->now());
            }

            $unitOfWork->recomputeSingleEntityChangeSet($classMeta, $entity);
        }

        // Check existing entities to be updated.
        foreach ($unitOfWork->getScheduledEntityUpdates() as $entity) {
            $entityClass = \get_class($entity);
            $extensionClassMetadata = $this->registry->getMetadata($entityClass);

            if ( ! $extensionClassMetadata->usesExtension(self::EXTENSION)) {
                continue;
            }

            /** @var TimestampableMetadata $timestampableMetadata */
            $timestampableMetadata = $extensionClassMetadata->getExtension(self::EXTENSION);

            if ( ! $timestampableMetadata->hasOnUpdateFields()) {
                continue;
            }

            $classMeta = $em->getClassMetadata($entityClass);

            foreach ($timestampableMetadata->getOnUpdateFields() as $field) {
                $property = $classMeta->getReflectionProperty($field);
                $property->setValue($entity, $this->clock->now());
            }

            $unitOfWork->recomputeSingleEntityChangeSet($classMeta, $entity);
        }
    }
}

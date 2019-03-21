<?php

declare(strict_types=1);

namespace Sandbox\Timestampable;

use Sandbox\Common\Metadata\ExtensionMetadata;

/**
 * TimestampableMetadata holds all Timestampable-related parsed metadata.
 *
 * @todo Functionality to add:
 * - Different types of dates/times per field
 * - Trigger based on other changed fields
 */
class TimestampableMetadata implements ExtensionMetadata
{
    /**
     * Fields that should be timestamped on creation.
     *
     * @var array|string[]
     */
    private $onCreateFields = [];

    /**
     * Fields that should be timestamped on update.
     *
     * @var array|string[]
     */
    private $onUpdateFields = [];

    public function getExtensionName(): string
    {
        return 'Timestampable';
    }

    public function hasOnCreateFields(): bool
    {
        return ! empty($this->onCreateFields);
    }

    public function getOnCreateFields(): array
    {
        return $this->onCreateFields;
    }

    public function addOnCreateField(string $field): void
    {
        $this->onCreateFields[$field] = $field;
    }

    public function hasOnUpdateFields(): bool
    {
        return ! empty($this->onUpdateFields);
    }

    public function getOnUpdateFields(): array
    {
        return $this->onUpdateFields;
    }

    public function addOnUpdateField(string $field): void
    {
        $this->onUpdateFields[$field] = $field;
    }
}

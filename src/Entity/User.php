<?php

declare(strict_types=1);

namespace Sandbox\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sandbox\Timestampable\Annotation\Timestampable;
use Sandbox\Timestampable\Timestampable as TimestampableInterface;

/**
 * @ORM\Entity()
 */
class User implements TimestampableInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Timestampable
     *
     * @var \DateTimeImmutable
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Timestampable
     *
     * @var \DateTimeImmutable
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=50)
     *
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function changeNameTo(string $name): void
    {
        $this->name = $name;
    }
}

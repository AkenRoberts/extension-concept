<?php

declare(strict_types=1);

namespace Sandbox\Timestampable\Annotation;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class Timestampable
{
}

<?php

namespace Mailery\Brand\Entity;

use Mailery\Activity\Log\Entity\LoggableEntityInterface;
use Mailery\Activity\Log\Entity\LoggableEntityTrait;

/**
 * @Cycle\Annotated\Annotation\Entity(
 *      table = "brands_channels",
 *      mapper = "Mailery\Brand\Mapper\BrandChannelMapper"
 * )
 */
class BrandChannel implements LoggableEntityInterface
{
    use LoggableEntityTrait;

    /**
     * @Cycle\Annotated\Annotation\Column(type = "primary")
     * @var int|null
     */
    private $id;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return 'BrandChannel';
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id ? (string) $this->id : null;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}

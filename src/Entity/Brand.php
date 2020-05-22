<?php

declare(strict_types=1);

/**
 * Brand module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-brand
 * @package   Mailery\Brand
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Brand\Entity;

use Mailery\Common\Entity\RoutableEntityInterface;
use Mailery\Activity\Log\Entity\LoggableEntityTrait;
use Mailery\Activity\Log\Entity\LoggableEntityInterface;

/**
 * @Cycle\Annotated\Annotation\Entity(
 *      table = "brands",
 *      repository = "Mailery\Brand\Repository\BrandRepository",
 *      mapper = "Mailery\Brand\Mapper\DefaultMapper",
 *      constrain = "Mailery\Brand\Constrain\DefaultConstrain"
 * )
 */
class Brand implements RoutableEntityInterface, LoggableEntityInterface
{
    use LoggableEntityTrait;

    const PASSWORD_RESET_TOKEN_EXPIRE = 3600;

    /**
     * @Cycle\Annotated\Annotation\Column(type = "primary")
     * @var int|null
     */
    private $id;

    /**
     * @Cycle\Annotated\Annotation\Column(type = "string(32)")
     * @var string
     */
    private $name;

    /**
     * @Cycle\Annotated\Annotation\Column(type = "text")
     * @var string
     */
    private $description;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName();
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

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getEditRouteName(): ?string
    {
        return '/brand/default/edit';
    }

    /**
     * @inheritdoc
     */
    public function getEditRouteParams(): array
    {
        return ['id' => $this->getId()];
    }

    /**
     * @inheritdoc
     */
    public function getViewRouteName(): ?string
    {
        return '/dashboard/default/index';
    }

    /**
     * @inheritdoc
     */
    public function getViewRouteParams(): array
    {
        return ['brandId' => $this->getId()];
    }
}

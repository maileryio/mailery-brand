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

use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Relation\ManyToMany;
use Mailery\Common\Entity\RoutableEntityInterface;
use Mailery\Activity\Log\Entity\LoggableEntityTrait;
use Mailery\Activity\Log\Entity\LoggableEntityInterface;
use Cycle\ORM\Collection\Pivoted\PivotedCollection;
use Mailery\Brand\Repository\BrandRepository;
use Mailery\Activity\Log\Mapper\LoggableMapper;
use Mailery\Channel\Entity\Channel;
use Mailery\Brand\Entity\BrandChannel;
use Cycle\ORM\Collection\DoctrineCollectionFactory;
use Cycle\ORM\Entity\Behavior;

#[Entity(
    table: 'brands',
    repository: BrandRepository::class,
    mapper: LoggableMapper::class,
)]
#[Behavior\CreatedAt(
    field: 'createdAt',
    column: 'created_at',
)]
#[Behavior\UpdatedAt(
    field: 'updatedAt',
    column: 'updated_at',
)]
class Brand implements RoutableEntityInterface, LoggableEntityInterface
{
    use LoggableEntityTrait;

    #[Column(type: 'primary')]
    private int $id;

    #[Column(type: 'string(255)')]
    private string $name;

    #[Column(type: 'text')]
    private string $description;

    #[ManyToMany(target: Channel::class, through: BrandChannel::class, collection: DoctrineCollectionFactory::class)]
    private PivotedCollection $channels;

    #[Column(type: 'datetime')]
    private \DateTimeImmutable $createdAt;

    #[Column(type: 'datetime', nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->channels = new PivotedCollection();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return PivotedCollection
     */
    public function getChannels(): PivotedCollection
    {
        return $this->channels;
    }

    /**
     * @param PivotedCollection $channels
     * @return self
     */
    public function setChannels(PivotedCollection $channels): self
    {
        $this->channels = $channels;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getIndexRouteName(): ?string
    {
        return '/user/default/index';
    }

    /**
     * @inheritdoc
     */
    public function getIndexRouteParams(): array
    {
        return [];
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
    public function getDeleteRouteName(): ?string
    {
        return '/brand/default/delete';
    }

    /**
     * @inheritdoc
     */
    public function getDeleteRouteParams(): array
    {
        return ['id' => $this->getId()];
    }
}

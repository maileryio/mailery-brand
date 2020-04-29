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

/**
 * @Cycle\Annotated\Annotation\Entity(
 *      table = "brands",
 *      repository = "Mailery\Brand\Repository\BrandRepository",
 *      mapper = "Yiisoft\Yii\Cycle\Mapper\TimestampedMapper"
 * )
 * @Cycle\Annotated\Annotation\Table(
 *      indexes = {
 *          @Cycle\Annotated\Annotation\Table\Index(columns = {"name"}, unique = true)
 *      }
 * )
 */
class Brand
{
    const STATUS_ACTIVE = 'active';
    const STATUS_DISABLED = 'disabled';

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
     * @Cycle\Annotated\Annotation\Column(type = "int", default = "0")
     * @var int
     */
    private $totalSubscribers = 0;

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
     * @return int
     */
    public function getTotalSubscribers(): int
    {
        return $this->totalSubscribers;
    }

    /**
     * @param int $totalSubscribers
     * @return self
     */
    public function setTotalSubscribers(int $totalSubscribers): self
    {
        $this->totalSubscribers = $totalSubscribers;

        return $this;
    }
}

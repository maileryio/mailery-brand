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

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Table;
use Cycle\Annotated\Annotation\Table\Index;
use Yiisoft\Auth\IdentityInterface;

/**
 * @Entity(
 *      table = "brands",
 *      repository = "Mailery\Brand\Repository\BrandRepository",
 *      mapper = "Yiisoft\Yii\Cycle\Mapper\TimestampedMapper"
 * )
 * @Table(
 *      indexes = {
 *          @Index(columns = {"name"}, unique = true)
 *      }
 * )
 */
class Brand implements IdentityInterface
{
    const STATUS_ACTIVE = 'active';
    const STATUS_DISABLED = 'disabled';

    const PASSWORD_RESET_TOKEN_EXPIRE = 3600;

    /**
     * @Column(type = "primary")
     * @var int|null
     */
    private $id;

    /**
     * @Column(type = "string(32)")
     * @var string
     */
    private $name;

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

}

<?php

declare(strict_types=1);

/**
 * Brand module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-brand
 * @package   Mailery\Brand
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Brand\Form;

use Mailery\Brand\Entity\Brand;
use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\Callback;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\InRange;
use Mailery\Brand\Repository\BrandRepository;
use Mailery\Channel\Repository\ChannelRepository;
use Mailery\Channel\Entity\Channel;
use Spiral\Database\Injection\Parameter;
use Yiisoft\Validator\Rule\Each;
use Yiisoft\Validator\RuleSet;

class BrandForm extends FormModel
{
    /**
     * @var string|null
     */
    private ?string $name = null;

    /**
     * @var string|null
     */
    private ?string $description = null;

    /**
     * @var array
     */
    private array $channels = [];

    /**
     * @var Brand
     */
    private ?Brand $brand = null;

    /**
     * @var BrandRepository
     */
    private BrandRepository $brandRepo;

    /**
     * @var ChannelRepository
     */
    private ChannelRepository $channelRepo;

    /**
     * @param BrandRepository $brandRepo
     * @param ChannelRepository $channelRepo
     */
    public function __construct(
        BrandRepository $brandRepo,
        ChannelRepository $channelRepo
    ) {
        $this->brandRepo = $brandRepo;
        $this->channelRepo = $channelRepo;
        parent::__construct();
    }

    /**
     * @param Brand $brand
     * @return self
     */
    public function withEntity(Brand $brand): self
    {
        $new = clone $this;
        $new->brand = $brand;
        $new->name = $brand->getName();
        $new->description = $brand->getDescription();
        $new->channels = $brand->getChannels()->map(
            fn (Channel $channel) => $channel->getId()
        )->toArray();

        return $new;
    }

    /**
     * @inheritdoc
     */
    public function load(array $data, ?string $formName = null): bool
    {
        $scope = $formName ?? $this->getFormName();

        if (isset($data[$scope]['channels'])) {
            $data[$scope]['channels'] = array_filter((array) $data[$scope]['channels']);
        }

        return parent::load($data, $formName);
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getChannels(): array
    {
        if (empty($this->channels)) {
            return [];
        }

        return $this->channelRepo->findAll([
            'id' => ['in' => new Parameter($this->channels, \PDO::PARAM_INT)],
        ]);
    }

    /**
     * @return array
     */
    public function getAttributeLabels(): array
    {
        return [
            'name' => 'Brand name',
            'description' => 'Description (optional)',
            'channels' => 'Available channels for this brand',
        ];
    }

    /**
     * @return array
     */
    public function getRules(): array
    {
        return [
            'name' => [
                Required::rule(),
                HasLength::rule()->min(4)->max(32),
                Callback::rule(function ($value) {
                    $result = new Result();
                    $record = $this->brandRepo->findByName($value, $this->brand);

                    if ($record !== null) {
                        $result->addError('This brand name already exists.');
                    }

                    return $result;
                })
            ],
            'channels' => [
                Required::rule(),
                Each::rule(new RuleSet([
                    InRange::rule(array_keys($this->getChannelListOptions())),
                ]))->message('{error}'),
            ],
        ];
    }

    /**
     * @return array
     */
    public function getChannelListOptions(): array
    {
        $listOptions = [];
        foreach ($this->channelRepo->findAll() as $channel) {
            /** @var Channel $channel */
            $listOptions[$channel->getId()] = $channel->getName();
        }

        return $listOptions;
    }
}

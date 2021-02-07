<?php

namespace Mailery\Brand\ValueObject;

use Mailery\Brand\Form\BrandForm;

class BrandValueObject
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $description;

    /**
     * @var array
     */
    private array $channels;

    /**
     * @param BrandForm $form
     * @return self
     */
    public static function fromForm(BrandForm $form): self
    {
        $new = new self();

        $new->name = $form->getAttributeValue('name');
        $new->description = $form->getAttributeValue('description');
        $new->channels = $form->getAttributeValue('channels');

        return $new;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getChannels(): array
    {
        return $this->channels;
    }
}

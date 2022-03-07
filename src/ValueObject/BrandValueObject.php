<?php

namespace Mailery\Brand\ValueObject;

use Mailery\Brand\Form\BrandForm;
use Mailery\Channel\Entity\Channel;

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
     * @var Channel[]
     */
    private array $channels;

    /**
     * @param BrandForm $form
     * @return self
     */
    public static function fromForm(BrandForm $form): self
    {
        $new = new self();
        $new->name = $form->getName();
        $new->description = $form->getDescription();
        $new->channels = $form->getChannels();

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
     * @return Channel[]
     */
    public function getChannels(): array
    {
        return $this->channels;
    }
}

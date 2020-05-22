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
     * @param BrandForm $form
     * @return self
     */
    public static function fromForm(BrandForm $form): self
    {
        $new = new self();

        $new->name = $form['name']->getValue();
        $new->description = $form['description']->getValue();

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
}

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

use Cycle\ORM\ORMInterface;
use Cycle\ORM\Transaction;
use FormManager\Factory as F;
use FormManager\Form;
use Mailery\Brand\Entity\Brand;
use Mailery\Brand\Repository\BrandRepository;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class BrandForm extends Form
{
    /**
     * @var ORMInterface
     */
    private ORMInterface $orm;

    /**
     * @var Brand|null
     */
    private ?Brand $brand;

    /**
     * {@inheritdoc}
     */
    public function __construct(ORMInterface $orm)
    {
        $this->orm = $orm;
        parent::__construct($this->inputs());
    }

    /**
     * @param Brand $brand
     * @return self
     */
    public function withBrand(Brand $brand): self
    {
        $this->brand = $brand;
        $this->offsetSet('', F::submit('Update'));

        $this['name']->setValue($brand->getName());
        $this['description']->setValue($brand->getDescription());

        return $this;
    }

    /**
     * @return Brand|null
     */
    public function save(): ?Brand
    {
        if (!$this->isValid()) {
            return null;
        }

        $name = $this['name']->getValue();
        $description = $this['description']->getValue();

        if (($brand = $this->brand) === null) {
            $brand = new Brand();
        }

        $brand
            ->setName($name)
            ->setDescription($description)
        ;

        $tr = new Transaction($this->orm);
        $tr->persist($brand);
        $tr->run();

        return $brand;
    }

    /**
     * @return array
     */
    private function inputs(): array
    {
        /** @var BrandRepository $brandRepo */
        $brandRepo = $this->orm->getRepository(Brand::class);

        $nameConstraint = new Constraints\Callback([
            'callback' => function ($value, ExecutionContextInterface $context) use ($brandRepo) {
                if (empty($value)) {
                    return;
                }

                $brand = $brandRepo->findByName($value, $this->brand);
                if ($brand !== null) {
                    $context->buildViolation('This brand name already exists.')
                        ->atPath('name')
                        ->addViolation();
                }
            },
        ]);

        return [
            'name' => F::text('Brand name', ['minlength' => 4, 'maxlength' => 32])
                ->addConstraint(new Constraints\NotBlank())
                ->addConstraint(new Constraints\Length([
                    'min' => 4,
                    'max' => 32,
                ]))
                ->addConstraint($nameConstraint),
            'description' => F::textarea('Description')
                ->addConstraint(new Constraints\NotBlank()),

            '' => F::submit($this->user === null ? 'Create' : 'Update'),
        ];
    }
}

<?php

namespace Mailery\Brand\Form;

use Mailery\Brand\Entity\Brand;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use FormManager\Form;
use FormManager\Factory as F;
use Cycle\ORM\Transaction;
use Cycle\ORM\ORMInterface;
use Yiisoft\Security\PasswordHasher;
use Mailery\Brand\Repository\BrandRepository;

class BrandForm extends Form
{

    /**
     * @var ORMInterface
     */
    private ORMInterface $orm;

    /**
     * @var Brand
     */
    private ?Brand $brand;

    /**
     * @inheritdoc
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
     * @return Brand
     */
    public function save(): Brand
    {
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
            'callback' => function ($value, ExecutionContextInterface $context) use($brandRepo) {
                if (empty($value)) {
                    return;
                }

                $brand = $brandRepo->findByName($value, $this->brand);
                if ($brand !== null) {
                    $context->buildViolation('This brand name already exists.')
                        ->atPath('name')
                        ->addViolation();
                }
            }
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

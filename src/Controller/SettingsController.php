<?php

declare(strict_types=1);

/**
 * Brand module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-brand
 * @package   Mailery\Brand
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Brand\Controller;

use Mailery\Brand\Form\BrandForm;
use Mailery\Brand\Service\BrandCrudService;
use Mailery\Brand\BrandLocatorInterface;
use Mailery\Brand\ValueObject\BrandValueObject;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Yiisoft\Http\Method;
use Yiisoft\Yii\View\ViewRenderer;
use Yiisoft\Validator\ValidatorInterface;
use Yiisoft\Session\Flash\FlashInterface;

class SettingsController
{
    /**
     * @param ViewRenderer $viewRenderer
     * @param BrandCrudService $brandCrudService
     * @param BrandLocatorInterface $brandLocator
     */
    public function __construct(
        private ViewRenderer $viewRenderer,
        private BrandCrudService $brandCrudService,
        private BrandLocatorInterface $brandLocator
    ) {
        $this->viewRenderer = $viewRenderer
            ->withController($this)
            ->withViewPath(dirname(dirname(__DIR__)) . '/views');
    }

    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param FlashInterface $flash
     * @param BrandForm $form
     * @return Response
     */
    public function basic(Request $request, ValidatorInterface $validator, FlashInterface $flash, BrandForm $form): Response
    {
        $body = $request->getParsedBody();
        $brand = $this->brandLocator->getBrand();

        $form = $form->withEntity($brand);

        if (($request->getMethod() === Method::POST) && $form->load($body) && $validator->validate($form)->isValid()) {
            $valueObject = BrandValueObject::fromForm($form);
            $this->brandCrudService->update($brand, $valueObject);

            $flash->add(
                'success',
                [
                    'body' => 'Settings have been saved!',
                ],
                true
            );
        }

        return $this->viewRenderer->render('basic', compact('brand', 'form'));
    }
}

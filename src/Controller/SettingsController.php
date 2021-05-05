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
use Yiisoft\Router\UrlGeneratorInterface as UrlGenerator;
use Yiisoft\Yii\View\ViewRenderer;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Yiisoft\Validator\ValidatorInterface;
use Yiisoft\Session\Flash\FlashInterface;

class SettingsController
{
    /**
     * @var ViewRenderer
     */
    private ViewRenderer $viewRenderer;

    /**
     * @var ResponseFactory
     */
    private ResponseFactory $responseFactory;

    /**
     * @var UrlGenerator
     */
    private UrlGenerator $urlGenerator;

    /**
     * @var BrandCrudService
     */
    private BrandCrudService $brandCrudService;

    /**
     * @var BrandLocatorInterface
     */
    private BrandLocatorInterface $brandLocator;

    /**
     * @param ViewRenderer $viewRenderer
     * @param ResponseFactory $responseFactory
     * @param UrlGenerator $urlGenerator
     * @param BrandCrudService $brandCrudService
     * @param BrandLocatorInterface $brandLocator
     */
    public function __construct(
        ViewRenderer $viewRenderer,
        ResponseFactory $responseFactory,
        UrlGenerator $urlGenerator,
        BrandCrudService $brandCrudService,
        BrandLocatorInterface $brandLocator
    ) {
        $this->viewRenderer = $viewRenderer
            ->withController($this)
            ->withViewBasePath(dirname(dirname(__DIR__)) . '/views');

        $this->responseFactory = $responseFactory;
        $this->urlGenerator = $urlGenerator;
        $this->brandCrudService = $brandCrudService;
        $this->brandLocator = $brandLocator;
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

        if (($request->getMethod() === Method::POST) && $form->load($body) && $validator->validate($form)) {
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

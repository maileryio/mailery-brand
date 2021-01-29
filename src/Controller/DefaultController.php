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
use Mailery\Brand\Repository\BrandRepository;
use Mailery\Subscriber\Counter\SubscriberCounter;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Yiisoft\Data\Reader\Sort;
use Yiisoft\Http\Method;
use Yiisoft\Router\UrlGeneratorInterface as UrlGenerator;
use Mailery\Brand\Service\BrandService;
use Mailery\Template\Model\TemplateTypeList;
use Yiisoft\Yii\View\ViewRenderer;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;

class DefaultController
{
    private const PAGINATION_INDEX = 10;

    /**
     * @var ViewRenderer
     */
    private ViewRenderer $viewRenderer;

    /**
     * @var ResponseFactory
     */
    private ResponseFactory $responseFactory;

    /**
     * @var BrandRepository
     */
    private BrandRepository $brandRepo;

    /**
     * @param ViewRenderer $viewRenderer
     * @param ResponseFactory $responseFactory
     * @param BrandRepository $brandRepo
     */
    public function __construct(ViewRenderer $viewRenderer, ResponseFactory $responseFactory, BrandRepository $brandRepo)
    {
        $this->viewRenderer = $viewRenderer
            ->withController($this)
            ->withViewBasePath(dirname(dirname(__DIR__)) . '/views');

        $this->responseFactory = $responseFactory;
        $this->brandRepo = $brandRepo;
    }

    /**
     * @param SubscriberCounter $subscriberCounter
     * @param TemplateTypeList $templateTypes
     * @return Response
     */
    public function index(SubscriberCounter $subscriberCounter, TemplateTypeList $templateTypes): Response
    {
        $dataReader = $this->brandRepo
            ->getDataReader()
            ->withSort(Sort::only(['id'])->withOrder(['id' => 'DESC']));

        return $this->viewRenderer->render('index', compact('dataReader', 'subscriberCounter', 'templateTypes'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function view(Request $request): Response
    {
        $brandId = $request->getAttribute('id');
        if (empty($brandId) || ($brand = $this->brandRepo->findByPK($brandId)) === null) {
            return $this->responseFactory->createResponse(404);
        }

        return $this->viewRenderer->render('view', compact('brand'));
    }

    /**
     * @param Request $request
     * @param BrandForm $brandForm
     * @param UrlGenerator $urlGenerator
     * @return Response
     */
    public function create(Request $request, BrandForm $brandForm, UrlGenerator $urlGenerator): Response
    {
        $brandForm
            ->setAttributes([
                'action' => $request->getUri()->getPath(),
                'method' => 'post',
                'enctype' => 'multipart/form-data',
            ]);

        $submitted = $request->getMethod() === Method::POST;

        if ($submitted) {
            $brandForm->loadFromServerRequest($request);

            if ($brandForm->save() !== null) {
                return $this->responseFactory
                    ->createResponse(302)
                    ->withHeader('Location', $urlGenerator->generate('/brand/default/index'));
            }
        }

        return $this->viewRenderer->render('create', compact('brandForm', 'submitted'));
    }

    /**
     * @param Request $request
     * @param BrandForm $brandForm
     * @param UrlGenerator $urlGenerator
     * @return Response
     */
    public function edit(Request $request, BrandForm $brandForm, UrlGenerator $urlGenerator): Response
    {
        $brandId = $request->getAttribute('id');
        if (empty($brandId) || ($brand = $this->brandRepo->findByPK($brandId)) === null) {
            return $this->responseFactory->createResponse(404);
        }

        $brandForm
            ->withBrand($brand)
            ->setAttributes([
                'action' => $request->getUri()->getPath(),
                'method' => 'post',
                'enctype' => 'multipart/form-data',
            ]);

        $submitted = $request->getMethod() === Method::POST;

        if ($submitted) {
            $brandForm->loadFromServerRequest($request);

            if ($brandForm->save() !== null) {
                return $this->responseFactory
                    ->createResponse(302)
                    ->withHeader('Location', $urlGenerator->generate('/brand/default/index'));
            }
        }

        return $this->viewRenderer->render('edit', compact('brand', 'brandForm', 'submitted'));
    }

    /**
     * @param Request $request
     * @param BrandService $brandService
     * @param UrlGenerator $urlGenerator
     * @return Response
     */
    public function delete(Request $request, BrandService $brandService, UrlGenerator $urlGenerator): Response
    {
        $brandId = $request->getAttribute('id');
        if (empty($brandId) || ($brand = $this->brandRepo->findByPK($brandId)) === null) {
            return $this->responseFactory->createResponse(404);
        }

        $brandService->delete($brand);

        return $this->responseFactory
            ->createResponse(302)
            ->withHeader('Location', $urlGenerator->generate('/brand/default/index'));
    }
}

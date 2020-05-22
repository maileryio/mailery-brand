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

use Mailery\Common\Web\Controller;
use Mailery\Brand\Entity\Brand;
use Mailery\Brand\Form\BrandForm;
use Mailery\Brand\Repository\BrandRepository;
use Mailery\Subscriber\Counter\SubscriberCounter;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Yiisoft\Data\Reader\Sort;
use Yiisoft\Http\Method;
use Yiisoft\Router\UrlGeneratorInterface as UrlGenerator;
use Mailery\Brand\Service\BrandService;

class DefaultController extends Controller
{
    private const PAGINATION_INDEX = 10;

    /**
     * @param SubscriberCounter $subscriberCounter
     * @return Response
     */
    public function index(SubscriberCounter $subscriberCounter): Response
    {
        $dataReader = $this->getBrandRepository()
            ->getDataReader()
            ->withSort((new Sort([]))->withOrderString('name'));

        return $this->render('index', compact('dataReader', 'subscriberCounter'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function view(Request $request): Response
    {
        $brandId = $request->getAttribute('id');
        if (empty($brandId) || ($brand = $this->getBrandRepository()->findByPK($brandId)) === null) {
            return $this->getResponseFactory()->createResponse(404);
        }

        return $this->render('view', compact('brand'));
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
                return $this->redirect($urlGenerator->generate('/brand/default/index'));
            }
        }

        return $this->render('create', compact('brandForm', 'submitted'));
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
        if (empty($brandId) || ($brand = $this->getBrandRepository()->findByPK($brandId)) === null) {
            return $this->getResponseFactory()->createResponse(404);
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
                return $this->redirect($urlGenerator->generate('/brand/default/index'));
            }
        }

        return $this->render('edit', compact('brand', 'brandForm', 'submitted'));
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
        if (empty($brandId) || ($brand = $this->getBrandRepository()->findByPK($brandId)) === null) {
            return $this->getResponseFactory()->createResponse(404);
        }

        $brandService->delete($brand);

        return $this->redirect($urlGenerator->generate('/brand/default/index'));
    }

    /**
     * @return BrandRepository
     */
    private function getBrandRepository(): BrandRepository
    {
        return $this->getOrm()->getRepository(Brand::class);
    }
}

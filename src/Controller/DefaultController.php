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

use Cycle\ORM\ORMInterface;
use Cycle\ORM\Transaction;
use Mailery\Brand\Controller;
use Mailery\Brand\Entity\Brand;
use Mailery\Brand\Form\BrandForm;
use Mailery\Brand\Repository\BrandRepository;
use Mailery\Subscriber\Counter\SubscriberCounter;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Yiisoft\Data\Reader\Sort;
use Yiisoft\Http\Method;
use Yiisoft\Router\UrlGeneratorInterface as UrlGenerator;

class DefaultController extends Controller
{
    private const PAGINATION_INDEX = 5;

    /**
     * @param ORMInterface $orm
     * @param SubscriberCounter $subscriberCounter
     * @return Response
     */
    public function index(ORMInterface $orm, SubscriberCounter $subscriberCounter): Response
    {
        $dataReader = $this->getBrandRepository($orm)
            ->getDataReader()
            ->withSort((new Sort([]))->withOrderString('name'));

        return $this->render('index', compact('dataReader', 'subscriberCounter'));
    }

    /**
     * @param Request $request
     * @param ORMInterface $orm
     * @return Response
     */
    public function view(Request $request, ORMInterface $orm): Response
    {
        $brandId = $request->getAttribute('id');
        if (empty($brandId) || ($brand = $this->getBrandRepository($orm)->findByPK($brandId)) === null) {
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
     * @param ORMInterface $orm
     * @param BrandForm $brandForm
     * @param UrlGenerator $urlGenerator
     * @return Response
     */
    public function edit(Request $request, ORMInterface $orm, BrandForm $brandForm, UrlGenerator $urlGenerator): Response
    {
        $brandId = $request->getAttribute('id');
        if (empty($brandId) || ($brand = $this->getBrandRepository($orm)->findByPK($brandId)) === null) {
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
     * @param ORMInterface $orm
     * @param UrlGenerator $urlGenerator
     * @return Response
     */
    public function delete(Request $request, ORMInterface $orm, UrlGenerator $urlGenerator): Response
    {
        $brandId = $request->getAttribute('id');
        if (empty($brandId) || ($brand = $this->getBrandRepository($orm)->findByPK($brandId)) === null) {
            return $this->getResponseFactory()->createResponse(404);
        }

        $tr = new Transaction($orm);
        $tr->delete($brand);
        $tr->run();

        return $this->redirect($urlGenerator->generate('/brand/default/index'));
    }

    /**
     * @param ORMInterface $orm
     * @return BrandRepository
     */
    private function getBrandRepository(ORMInterface $orm): BrandRepository
    {
        return $orm->getRepository(Brand::class);
    }
}

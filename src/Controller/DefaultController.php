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
use Mailery\Brand\ValueObject\BrandValueObject;
use Mailery\Subscriber\Counter\SubscriberCounter;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Yiisoft\Data\Reader\Sort;
use Yiisoft\Http\Method;
use Yiisoft\Http\Status;
use Yiisoft\Http\Header;
use Yiisoft\Router\UrlGeneratorInterface as UrlGenerator;
use Mailery\Brand\Service\BrandCrudService;
use Mailery\Channel\Model\ChannelTypeList;
use Yiisoft\Yii\View\ViewRenderer;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Yiisoft\Validator\ValidatorInterface;
use Yiisoft\Router\CurrentRoute;

class DefaultController
{

    /**
     * @param ViewRenderer $viewRenderer
     * @param ResponseFactory $responseFactory
     * @param UrlGenerator $urlGenerator
     * @param BrandRepository $brandRepo
     * @param BrandCrudService $brandCrudService
     */
    public function __construct(
        private ViewRenderer $viewRenderer,
        private ResponseFactory $responseFactory,
        private UrlGenerator $urlGenerator,
        private BrandRepository $brandRepo,
        private BrandCrudService $brandCrudService
    ) {
        $this->viewRenderer = $viewRenderer
            ->withController($this)
            ->withViewPath(dirname(dirname(__DIR__)) . '/views');
    }

    /**
     * @param SubscriberCounter $subscriberCounter
     * @param ChannelTypeList $channelTypeList
     * @return Response
     */
    public function index(SubscriberCounter $subscriberCounter, ChannelTypeList $channelTypeList): Response
    {
        $dataReader = $this->brandRepo
            ->getDataReader()
            ->withSort(Sort::only(['id'])->withOrder(['id' => 'DESC']));

        return $this->viewRenderer->render('index', compact('dataReader', 'subscriberCounter', 'channelTypeList'));
    }

    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param BrandForm $form
     * @return Response
     */
    public function create(Request $request, ValidatorInterface $validator, BrandForm $form): Response
    {
        $body = $request->getParsedBody();

        if (($request->getMethod() === Method::POST) && $form->load($body) && $validator->validate($form)->isValid()) {
            $valueObject = BrandValueObject::fromForm($form);
            $this->brandCrudService->create($valueObject);

            return $this->responseFactory
                ->createResponse(Status::FOUND)
                ->withHeader(Header::LOCATION, $this->urlGenerator->generate('/brand/default/index'));
        }

        return $this->viewRenderer->render('create', compact('form'));
    }

    /**
     * @param CurrentRoute $currentRoute
     * @param BrandCrudService $brandCrudService
     * @return Response
     */
    public function delete(CurrentRoute $currentRoute, BrandCrudService $brandCrudService): Response
    {
        $brandId = (int) $currentRoute->getArgument('id');
        if (empty($brandId) || ($brand = $this->brandRepo->findByPK($brandId)) === null) {
            return $this->responseFactory->createResponse(Status::NOT_FOUND);
        }

        $brandCrudService->delete($brand);

        return $this->responseFactory
            ->createResponse(Status::SEE_OTHER)
            ->withHeader(Header::LOCATION, $this->urlGenerator->generate('/brand/default/index'));
    }

}

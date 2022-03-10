<?php

declare(strict_types=1);

/**
 * Brand module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-brand
 * @package   Mailery\Brand
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Brand\Middleware;

use Mailery\Brand\Exception\BrandRequiredException;
use Mailery\Brand\BrandLocatorInterface as BrandLocator;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Yii\Middleware\Redirect;

class BrandMiddleware implements MiddlewareInterface
{
    /**
     * @var string
     */
    private string $route;

    /**
     * @var array
     */
    private array $arguments = [];

    /**
     * @var ResponseFactoryInterface
     */
    private ResponseFactoryInterface $responseFactory;

    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $urlGenerator;

    /**
     * @var BrandLocator
     */
    private BrandLocator $brandLocator;

    /**
     * @param ResponseFactoryInterface $responseFactory
     * @param UrlGeneratorInterface $urlGenerator
     * @param BrandLocator $brandLocator
     */
    public function __construct(ResponseFactoryInterface $responseFactory, UrlGeneratorInterface $urlGenerator, BrandLocator $brandLocator)
    {
        $this->responseFactory = $responseFactory;
        $this->urlGenerator = $urlGenerator;
        $this->brandLocator = $brandLocator;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return self
     */
    public function withRoute(string $name, array $arguments = []): self
    {
        $new = clone $this;
        $new->route = $name;
        $new->arguments = $arguments;

        return $new;
    }

    /**
     * @param Request $request
     * @param RequestHandlerInterface $handler
     * @return Response
     */
    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        $this->brandLocator->locate($request);

        if ($this->brandLocator->hasBrand()) {
            $this->urlGenerator->setDefaultArgument('brandId', $this->brandLocator->getBrand()->getId());
        }

        try {
            return $handler->handle($request);
        } catch (BrandRequiredException $e) {
            $path = $request->getUri()->getPath();
            $redirect = $this->urlGenerator->generate($this->route, $this->arguments);

            if ($path !== $redirect) {
                return (new Redirect($this->responseFactory, $this->urlGenerator))
                    ->toUrl($redirect)
                    ->temporary()
                    ->process($request, $handler);
            }

            throw $e;
        }
    }
}

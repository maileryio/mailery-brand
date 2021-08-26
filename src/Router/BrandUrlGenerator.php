<?php

declare(strict_types=1);

/**
 * Brand module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-brand
 * @package   Mailery\Brand
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Brand\Router;

use FastRoute\RouteParser;
use Mailery\Brand\BrandLocatorInterface as BrandLocator;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Router\FastRoute\UrlGenerator;
use Yiisoft\Router\RouteCollectionInterface;
use Yiisoft\Router\UrlGeneratorInterface;

class BrandUrlGenerator implements UrlGeneratorInterface
{
    /**
     * @var BrandLocator
     */
    private BrandLocator $brandLocator;

    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $urlGenerator;

    /**
     * @var RouteCollectionInterface
     */
    private RouteCollectionInterface $routeCollection;

    /**
     * @var RouteParser
     */
    private RouteParser $routeParser;

    /**
     * @param BrandLocator $brandLocator
     * @param RouteCollectionInterface $routeCollection
     * @param CurrentRoute $currentRoute
     * @param RouteParser|null $parser
     */
    public function __construct(BrandLocator $brandLocator, RouteCollectionInterface $routeCollection, CurrentRoute $currentRoute, RouteParser $parser = null)
    {
        $this->brandLocator = $brandLocator;
        $this->urlGenerator = new UrlGenerator($routeCollection, $currentRoute, $parser);
        $this->routeCollection = $routeCollection;
        $this->routeParser = $parser ?? new RouteParser\Std();
    }

    /**
     * {@inheritdoc}
     */
    public function generate(string $name, array $parameters = []): string
    {
        return $this->urlGenerator->generate(
            $name,
            $this->injectParameters($name, $parameters)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function generateAbsolute(string $name, array $parameters = [], string $scheme = null, string $host = null): string
    {
        return $this->urlGenerator->generateAbsolute(
            $name,
            $this->injectParameters($name, $parameters),
            $scheme,
            $host
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getUriPrefix(): string
    {
        return $this->urlGenerator->getUriPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function setEncodeRaw(bool $encodeRaw): void
    {
        $this->urlGenerator->setEncodeRaw($encodeRaw);
    }

    /**
     * {@inheritdoc}
     */
    public function setUriPrefix(string $name): void
    {
        $this->urlGenerator->setUriPrefix($name);
    }

    /**
     * @param string $name
     * @param array $parameters
     * @return array
     */
    private function injectParameters(string $name, array $parameters = []): array
    {
        if (!isset($parameters['brandId'])) {
            $route = $this->routeCollection->getRoute($name);
            $parsedRoutes = array_reverse($this->routeParser->parse($route->getPattern()));

            foreach ($parsedRoutes as $parsedRouteParts) {
                foreach ($parsedRouteParts as $parsedRoutePart) {
                    if (is_string($parsedRoutePart)) {
                        continue;
                    }

                    if ($parsedRoutePart[0] === 'brandId') {
                        $parameters['brandId'] = $this->brandLocator->getBrand()->getId();
                    }
                }
            }
        }

        return $parameters;
    }
}

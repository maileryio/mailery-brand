<?php

namespace Mailery\Brand\Router;

use Mailery\Brand\Service\BrandLocator;
use Yiisoft\Router\RouteCollectionInterface;
use Yiisoft\Router\UrlMatcherInterface;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Router\FastRoute\UrlGenerator;
use FastRoute\RouteParser;

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
     * @param UrlMatcherInterface $matcher
     * @param RouteParser $parser
     */
    public function __construct(BrandLocator $brandLocator, UrlMatcherInterface $matcher, RouteParser $parser = null)
    {
        $this->brandLocator = $brandLocator;
        $this->urlGenerator = new UrlGenerator($matcher, $parser);
        $this->routeCollection = $matcher->getRouteCollection();
        $this->routeParser = $parser ?? new RouteParser\Std();
    }

    /**
     * @inheritdoc
     */
    public function generate(string $name, array $parameters = []): string
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

        return $this->urlGenerator->generate($name, $parameters);
    }

    /**
     * @inheritdoc
     */
    public function generateAbsolute(string $name, array $parameters = [], string $scheme = null, string $host = null): string
    {
        return $this->urlGenerator->generateAbsolute($name, $parameters, $scheme, $host);
    }

    /**
     * @inheritdoc
     */
    public function getUriPrefix(): string
    {
        return $this->urlGenerator->getUriPrefix();
    }

    /**
     * @inheritdoc
     */
    public function setUriPrefix(string $name): void
    {
        $this->urlGenerator->setUriPrefix($name);
    }

}

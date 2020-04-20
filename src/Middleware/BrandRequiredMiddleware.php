<?php

namespace Mailery\Brand\Middleware;

use Mailery\Brand\Exception\BrandRequiredException;
use Mailery\Brand\Service\BrandLocator;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Yii\Web\Middleware\Redirect;

class BrandRequiredMiddleware implements MiddlewareInterface
{
    /**
     * @var string|null
     */
    private ?string $route = null;

    /**
     * @var array
     */
    private array $parameters = [];

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
     * @param array $parameters
     * @return \self
     */
    public function toRoute(string $name, array $parameters = []): self
    {
        $this->route = $name;
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * @param Request $request
     * @param RequestHandlerInterface $handler
     * @return Response
     */
    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        $this->brandLocator->locate($request);

        try {
            return $handler->handle($request);
        } catch (BrandRequiredException $e) {
            $path = $request->getUri()->getPath();
            $redirect = $this->urlGenerator->generate($this->route, $this->parameters);

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
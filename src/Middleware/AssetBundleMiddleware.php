<?php

namespace Mailery\Brand\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Mailery\Assets\AssetBundleRegistry;
use Mailery\Brand\Assets\BrandAssetBundle;

class AssetBundleMiddleware implements MiddlewareInterface
{
    /**
     * @param AssetBundleRegistry $assetBundleRegistry
     */
    public function __construct(
        private AssetBundleRegistry $assetBundleRegistry
    ) {}

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->assetBundleRegistry->add(BrandAssetBundle::class);

        return $handler->handle($request);
    }
}

<?php
declare(strict_types=1);

namespace App\FrontPage\RequestHandler;

use App\View\DefaultTemplate;
use App\FrontPage\View\FrontPage as FrontPageView;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class FrontPage implements RequestHandlerInterface
{

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse(
            (new DefaultTemplate(
                'Super secure hosting',
                new FrontPageView())
            )->render()
        );
    }
}
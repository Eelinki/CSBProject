<?php
declare(strict_types=1);

namespace App\Index;

use App\Template\DefaultTemplate;
use App\Template\FrontPageView;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class FrontPage implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response\HtmlResponse(
            (new DefaultTemplate(
                'Super secure hosting',
                new FrontPageView())
            )->render()
        );
    }
}
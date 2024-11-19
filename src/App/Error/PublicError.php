<?php
declare(strict_types=1);

namespace App\Error;

use App\Template\DefaultTemplate;
use App\Template\Error;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class PublicError implements RequestHandlerInterface
{
    public function __construct(
        private int $code,
        private string $phrase
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return (new HtmlResponse(
            (new DefaultTemplate(
                $this->phrase,
                new Error($this->code, $this->phrase))
            )->render()
        ))->withStatus($this->code, $this->phrase);
    }
}
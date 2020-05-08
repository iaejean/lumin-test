<?php

declare(strict_types=1);

namespace App\Listener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Class ExceptionListener
 * @package App\Listener
 */
final class ExceptionListener
{
    private LoggerInterface $logger;

    /**
     * ExceptionListener constructor.
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable()->getPrevious() ?? $event->getThrowable();
        $this->logger->warning($exception->getTraceAsString());

        if ($exception instanceof HttpExceptionInterface) {
            $code = $exception->getStatusCode();
        }

        $code = isset($code) ? Response::HTTP_BAD_REQUEST : Response::HTTP_INTERNAL_SERVER_ERROR;
        $message = $exception->getMessage();

        $event->setResponse(
            new JsonResponse(
                json_encode(['message' => $message]),
                $code,
                ['Content-Type' => 'application/json'],
                true
            )
        );
    }
}
